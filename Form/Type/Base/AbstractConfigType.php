<?php
/**
 * DownLoad.
 *
 * @copyright Ralf Koester (RK)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Ralf Koester <ralf@familie-koester.de>.
 * @link http://k62.de
 * @link https://ziku.la
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace RK\DownLoadModule\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use RK\DownLoadModule\Form\Type\Field\MultiListType;
use RK\DownLoadModule\AppSettings;
use RK\DownLoadModule\Helper\ListEntriesHelper;

/**
 * Configuration form type base class.
 */
abstract class AbstractConfigType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var ListEntriesHelper
     */
    protected $listHelper;

    /**
     * ConfigType constructor.
     *
     * @param TranslatorInterface $translator Translator service instance
     * @param ListEntriesHelper $listHelper ListEntriesHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        ListEntriesHelper $listHelper
    ) {
        $this->setTranslator($translator);
        $this->listHelper = $listHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addListViewsFields($builder, $options);
        $this->addModerationFields($builder, $options);
        $this->addIntegrationFields($builder, $options);

        $this->addSubmitButtons($builder, $options);
    }

    /**
     * Adds fields for list views fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addListViewsFields(FormBuilderInterface $builder, array $options = [])
    {
        
        $builder->add('fileEntriesPerPage', IntegerType::class, [
            'label' => $this->__('File entries per page') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('The amount of files shown per page')
            ],
            'help' => $this->__('The amount of files shown per page'),
            'empty_data' => 10,
            'attr' => [
                'maxlength' => 11,
                'class' => '',
                'title' => $this->__('Enter the file entries per page.') . ' ' . $this->__('Only digits are allowed.')
            ],
            'required' => true,
            'scale' => 0
        ]);
        
        $builder->add('linkOwnFilesOnAccountPage', CheckboxType::class, [
            'label' => $this->__('Link own files on account page') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Whether to add a link to files of the current user on his account page')
            ],
            'help' => $this->__('Whether to add a link to files of the current user on his account page'),
            'attr' => [
                'class' => '',
                'title' => $this->__('The link own files on account page option')
            ],
            'required' => false,
        ]);
        
        $builder->add('filePrivateMode', CheckboxType::class, [
            'label' => $this->__('File private mode') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Whether users may only see own files')
            ],
            'help' => $this->__('Whether users may only see own files'),
            'attr' => [
                'class' => '',
                'title' => $this->__('The file private mode option')
            ],
            'required' => false,
        ]);
        
        $builder->add('showOnlyOwnEntries', CheckboxType::class, [
            'label' => $this->__('Show only own entries') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Whether only own entries should be shown on view pages by default or not')
            ],
            'help' => $this->__('Whether only own entries should be shown on view pages by default or not'),
            'attr' => [
                'class' => '',
                'title' => $this->__('The show only own entries option')
            ],
            'required' => false,
        ]);
    }

    /**
     * Adds fields for moderation fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addModerationFields(FormBuilderInterface $builder, array $options = [])
    {
        
        $builder->add('allowModerationSpecificCreatorForFile', CheckboxType::class, [
            'label' => $this->__('Allow moderation specific creator for file') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Whether to allow moderators choosing a user which will be set as creator.')
            ],
            'help' => $this->__('Whether to allow moderators choosing a user which will be set as creator.'),
            'attr' => [
                'class' => '',
                'title' => $this->__('The allow moderation specific creator for file option')
            ],
            'required' => false,
        ]);
        
        $builder->add('allowModerationSpecificCreationDateForFile', CheckboxType::class, [
            'label' => $this->__('Allow moderation specific creation date for file') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Whether to allow moderators choosing a custom creation date.')
            ],
            'help' => $this->__('Whether to allow moderators choosing a custom creation date.'),
            'attr' => [
                'class' => '',
                'title' => $this->__('The allow moderation specific creation date for file option')
            ],
            'required' => false,
        ]);
    }

    /**
     * Adds fields for integration fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addIntegrationFields(FormBuilderInterface $builder, array $options = [])
    {
        
        $listEntries = $this->listHelper->getEntries('appSettings', 'enabledFinderTypes');
        $choices = [];
        $choiceAttributes = [];
        foreach ($listEntries as $entry) {
            $choices[$entry['text']] = $entry['value'];
            $choiceAttributes[$entry['text']] = ['title' => $entry['title']];
        }
        $builder->add('enabledFinderTypes', MultiListType::class, [
            'label' => $this->__('Enabled finder types') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Which sections are supported in the Finder component (used by Scribite plug-ins).')
            ],
            'help' => $this->__('Which sections are supported in the Finder component (used by Scribite plug-ins).'),
            'empty_data' => 'file',
            'attr' => [
                'class' => '',
                'title' => $this->__('Choose the enabled finder types.')
            ],
            'required' => false,
            'placeholder' => $this->__('Choose an option'),
            'choices' => $choices,
            'choice_attr' => $choiceAttributes,
            'multiple' => true,
            'expanded' => false
        ]);
    }

    /**
     * Adds submit buttons.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addSubmitButtons(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('save', SubmitType::class, [
            'label' => $this->__('Update configuration'),
            'icon' => 'fa-check',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $builder->add('reset', ResetType::class, [
            'label' => $this->__('Reset'),
            'icon' => 'fa-refresh',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
        $builder->add('cancel', SubmitType::class, [
            'label' => $this->__('Cancel'),
            'icon' => 'fa-times',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'rkdownloadmodule_config';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data
                'data_class' => AppSettings::class,
            ]);
    }
}
