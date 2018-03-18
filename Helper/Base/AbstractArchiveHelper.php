<?php
/**
 * DownLoad.
 *
 * @copyright Ralf Koester (RK)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Ralf Koester <ralf@familie-koester.de>.
 * @link http://oldtimer-ig-osnabrueck.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace RK\DownLoadModule\Helper\Base;

use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Core\RouteUrl;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use RK\DownLoadModule\Entity\Factory\EntityFactory;
use RK\DownLoadModule\Helper\HookHelper;
use RK\DownLoadModule\Helper\WorkflowHelper;

/**
 * Archive helper base class.
 */
abstract class AbstractArchiveHelper
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var WorkflowHelper
     */
    protected $workflowHelper;

    /**
     * @var HookHelper
     */
    protected $hookHelper;

    /**
     * ArchiveHelper constructor.
     *
     * @param TranslatorInterface    $translator     Translator service instance
     * @param RequestStack           $requestStack   RequestStack service instance
     * @param LoggerInterface        $logger         Logger service instance
     * @param PermissionApiInterface $permissionApi  PermissionApi service instance
     * @param EntityFactory          $entityFactory  EntityFactory service instance
     * @param WorkflowHelper         $workflowHelper WorkflowHelper service instance
     * @param HookHelper             $hookHelper     HookHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        LoggerInterface $logger,
        PermissionApiInterface $permissionApi,
        EntityFactory $entityFactory,
        WorkflowHelper $workflowHelper,
        HookHelper $hookHelper
    ) {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->logger = $logger;
        $this->permissionApi = $permissionApi;
        $this->entityFactory = $entityFactory;
        $this->workflowHelper = $workflowHelper;
        $this->hookHelper = $hookHelper;
    }

    /**
     * Moves obsolete data into the archive.
     *
     * @param integer $probabilityPercent Execution probability
     */
    public function archiveObsoleteObjects($probabilityPercent = 75)
    {
        $randProbability = mt_rand(1, 100);
        if ($randProbability < $probabilityPercent) {
            return;
        }
    
        if (!$this->permissionApi->hasPermission('RKDownLoadModule', '.*', ACCESS_EDIT)) {
            // abort if current user has no permission for executing the archive workflow action
            return;
        }
    
        // perform update for files becoming archived
        $logArgs = ['app' => 'RKDownLoadModule', 'entity' => 'file'];
        $this->logger->notice('{app}: Automatic archiving for the {entity} entity started.', $logArgs);
        $this->archiveFiles();
        $this->logger->notice('{app}: Automatic archiving for the {entity} entity completed.', $logArgs);
    }
    
    /**
     * Moves files into the archive which reached their end date.
     *
     * @throws RuntimeException Thrown if workflow action execution fails
     */
    protected function archiveFiles()
    {
        $today = date('Y-m-d') . ' 00:00:00';
    
        $affectedEntities = $this->getObjectsToBeArchived('file', 'endDate', $today);
        foreach ($affectedEntities as $entity) {
            $this->archiveSingleObject($entity);
        }
    }
    
    /**
     * Returns the list of entities which should be archived.
     *
     * @param string $objectType Name of treated entity type
     * @param string $endField   Name of field storing the end date
     * @param mixed  $endDate    Datetime or date string for the threshold date
     *
     * @return array List of affected entities
     */
    protected function getObjectsToBeArchived($objectType = '', $endField = '', $endDate = '')
    {
        $repository = $this->entityFactory->getRepository($objectType);
        $qb = $repository->genericBaseQuery('', '', false);
    
        /*$qb->andWhere('tbl.workflowState != :archivedState')
           ->setParameter('archivedState', 'archived');*/
        $qb->andWhere('tbl.workflowState = :approvedState')
           ->setParameter('approvedState', 'approved');
    
        $qb->andWhere('tbl.' . $endField . ' < :endThreshold')
           ->setParameter('endThreshold', $endDate);
    
        $query = $repository->getQueryFromBuilder($qb);
    
        return $query->getResult();
    }
    
    /**
     * Archives a single entity.
     *
     * @param object $entity The given entity instance
     *
     * @return boolean True if everything worked successfully, false otherwise
     */
    protected function archiveSingleObject($entity)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($entity->supportsHookSubscribers()) {
            // Let any hooks perform additional validation actions
            $validationErrors = $this->hookHelper->callValidationHooks($entity, UiHooksCategory::TYPE_VALIDATE_EDIT);
            if (count($validationErrors) > 0) {
                if (null !== $request) {
                    $flashBag = $request->getSession()->getFlashBag();
                    foreach ($validationErrors as $message) {
                        $flashBag->add('error', $message);
                    }
                }
    
                return false;
            }
        }
    
        $success = false;
        try {
            // execute the workflow action
            $success = $this->workflowHelper->executeAction($entity, 'archive');
        } catch (\Exception $exception) {
            if (null !== $request) {
                $flashBag = $request->getSession()->getFlashBag();
                $flashBag->add('error', $this->translator->__f('Sorry, but an error occured during the %action% action. Please apply the changes again!', ['%action%' => $action]) . '  ' . $exception->getMessage());
            }
        }
    
        if (!$success) {
            return false;
        }
    
        if ($entity->supportsHookSubscribers()) {
            // Let any hooks know that we have updated an item
            $objectType = $entity->get_objectType();
            $url = null;
    
            $hasDisplayPage = in_array($objectType, ['file']);
            if ($hasDisplayPage) {
                $urlArgs = $entity->createUrlArgs();
                if (null !== $request) {
                    $urlArgs['_locale'] = $request->getLocale();
                }
                $url = new RouteUrl('rkdownloadmodule_' . strtolower($objectType) . '_display', $urlArgs);
        	}
            $this->hookHelper->callProcessHooks($entity, UiHooksCategory::TYPE_PROCESS_EDIT, $url);
        }
    }
}