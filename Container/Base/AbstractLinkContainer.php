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

namespace RK\DownLoadModule\Container\Base;

use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use RK\DownLoadModule\Helper\ControllerHelper;

/**
 * This is the link container service implementation class.
 */
abstract class AbstractLinkContainer implements LinkContainerInterface
{
    use TranslatorTrait;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;

    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * @var ControllerHelper
     */
    protected $controllerHelper;

    /**
     * LinkContainer constructor.
     *
     * @param TranslatorInterface    $translator       Translator service instance
     * @param Routerinterface        $router           Router service instance
     * @param PermissionApiInterface $permissionApi    PermissionApi service instance
     * @param VariableApiInterface   $variableApi      VariableApi service instance
     * @param ControllerHelper       $controllerHelper ControllerHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RouterInterface $router,
        PermissionApiInterface $permissionApi,
        VariableApiInterface $variableApi,
        ControllerHelper $controllerHelper
    ) {
        $this->setTranslator($translator);
        $this->router = $router;
        $this->permissionApi = $permissionApi;
        $this->variableApi = $variableApi;
        $this->controllerHelper = $controllerHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns available header links.
     *
     * @param string $type The type to collect links for
     *
     * @return array List of header links
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $contextArgs = ['api' => 'linkContainer', 'action' => 'getLinks'];
        $allowedObjectTypes = $this->controllerHelper->getObjectTypes('api', $contextArgs);

        $permLevel = LinkContainerInterface::TYPE_ADMIN == $type ? ACCESS_ADMIN : ACCESS_READ;

        // Create an array of links to return
        $links = [];

        if (LinkContainerInterface::TYPE_ACCOUNT == $type) {
            if (!$this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_OVERVIEW)) {
                return $links;
            }

            if (true === $this->variableApi->get('RKDownLoadModule', 'linkOwnFilesOnAccountPage', true)) {
                $objectType = 'file';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('rkdownloadmodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My files', 'rkdownloadmodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('rkdownloadmodule_file_adminindex'),
                    'text' => $this->__('Down load Backend', 'rkdownloadmodule'),
                    'icon' => 'wrench'
                ];
            }


            return $links;
        }

        $routeArea = LinkContainerInterface::TYPE_ADMIN == $type ? 'admin' : '';
        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
                $links[] = [
                    'url' => $this->router->generate('rkdownloadmodule_file_index'),
                    'text' => $this->__('Frontend', 'rkdownloadmodule'),
                    'title' => $this->__('Switch to user area.', 'rkdownloadmodule'),
                    'icon' => 'home'
                ];
            }
        } else {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('rkdownloadmodule_file_adminindex'),
                    'text' => $this->__('Backend', 'rkdownloadmodule'),
                    'title' => $this->__('Switch to administration area.', 'rkdownloadmodule'),
                    'icon' => 'wrench'
                ];
            }
        }
        
        if (in_array('file', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':File:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('rkdownloadmodule_file_' . $routeArea . 'view'),
                'text' => $this->__('Files', 'rkdownloadmodule'),
                'title' => $this->__('Files list', 'rkdownloadmodule')
            ];
        }
        if ($routeArea == 'admin' && $this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('rkdownloadmodule_config_config'),
                'text' => $this->__('Configuration', 'rkdownloadmodule'),
                'title' => $this->__('Manage settings for this application', 'rkdownloadmodule'),
                'icon' => 'wrench'
            ];
        }

        return $links;
    }

    /**
     * Returns the name of the providing bundle.
     *
     * @return string The bundle name
     */
    public function getBundleName()
    {
        return 'RKDownLoadModule';
    }
}
