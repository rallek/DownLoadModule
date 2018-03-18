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

namespace RK\DownLoadModule\Base;

use Symfony\Component\Validator\Constraints as Assert;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use RK\DownLoadModule\Validator\Constraints as DownLoadAssert;

/**
 * Application settings class for handling module variables.
 */
abstract class AbstractAppSettings
{
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;
    
    /**
     * The amount of files shown per page
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var integer $fileEntriesPerPage
     */
    protected $fileEntriesPerPage = 10;
    
    /**
     * Whether to add a link to files of the current user on his account page
     *
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $linkOwnFilesOnAccountPage
     */
    protected $linkOwnFilesOnAccountPage = true;
    
    /**
     * Which sections are supported in the Finder component (used by Scribite plug-ins).
     *
     * @Assert\NotNull()
     * @DownLoadAssert\ListEntry(entityName="appSettings", propertyName="enabledFinderTypes", multiple=true)
     * @var string $enabledFinderTypes
     */
    protected $enabledFinderTypes = 'file';
    
    
    /**
     * AppSettings constructor.
     *
     * @param VariableApiInterface $variableApi VariableApi service instance
     */
    public function __construct(
        VariableApiInterface $variableApi
    ) {
        $this->variableApi = $variableApi;
    
        $this->load();
    }
    
    /**
     * Returns the file entries per page.
     *
     * @return integer
     */
    public function getFileEntriesPerPage()
    {
        return $this->fileEntriesPerPage;
    }
    
    /**
     * Sets the file entries per page.
     *
     * @param integer $fileEntriesPerPage
     *
     * @return void
     */
    public function setFileEntriesPerPage($fileEntriesPerPage)
    {
        if (intval($this->fileEntriesPerPage) !== intval($fileEntriesPerPage)) {
            $this->fileEntriesPerPage = intval($fileEntriesPerPage);
        }
    }
    
    /**
     * Returns the link own files on account page.
     *
     * @return boolean
     */
    public function getLinkOwnFilesOnAccountPage()
    {
        return $this->linkOwnFilesOnAccountPage;
    }
    
    /**
     * Sets the link own files on account page.
     *
     * @param boolean $linkOwnFilesOnAccountPage
     *
     * @return void
     */
    public function setLinkOwnFilesOnAccountPage($linkOwnFilesOnAccountPage)
    {
        if (boolval($this->linkOwnFilesOnAccountPage) !== boolval($linkOwnFilesOnAccountPage)) {
            $this->linkOwnFilesOnAccountPage = boolval($linkOwnFilesOnAccountPage);
        }
    }
    
    /**
     * Returns the enabled finder types.
     *
     * @return string
     */
    public function getEnabledFinderTypes()
    {
        return $this->enabledFinderTypes;
    }
    
    /**
     * Sets the enabled finder types.
     *
     * @param string $enabledFinderTypes
     *
     * @return void
     */
    public function setEnabledFinderTypes($enabledFinderTypes)
    {
        if ($this->enabledFinderTypes !== $enabledFinderTypes) {
            $this->enabledFinderTypes = isset($enabledFinderTypes) ? $enabledFinderTypes : '';
        }
    }
    
    
    /**
     * Loads module variables from the database.
     */
    protected function load()
    {
        $moduleVars = $this->variableApi->getAll('RKDownLoadModule');
    
        if (isset($moduleVars['fileEntriesPerPage'])) {
            $this->setFileEntriesPerPage($moduleVars['fileEntriesPerPage']);
        }
        if (isset($moduleVars['linkOwnFilesOnAccountPage'])) {
            $this->setLinkOwnFilesOnAccountPage($moduleVars['linkOwnFilesOnAccountPage']);
        }
        if (isset($moduleVars['enabledFinderTypes'])) {
            $this->setEnabledFinderTypes($moduleVars['enabledFinderTypes']);
        }
    }
    
    /**
     * Saves module variables into the database.
     */
    public function save()
    {
        $this->variableApi->set('RKDownLoadModule', 'fileEntriesPerPage', $this->getFileEntriesPerPage());
        $this->variableApi->set('RKDownLoadModule', 'linkOwnFilesOnAccountPage', $this->getLinkOwnFilesOnAccountPage());
        $this->variableApi->set('RKDownLoadModule', 'enabledFinderTypes', $this->getEnabledFinderTypes());
    }
}
