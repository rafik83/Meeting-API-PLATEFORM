<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\ChoiceList\Loader\IntlCallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Intl\Languages;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportedLanguageType extends AbstractType
{
    public function __construct(
        private array $supportedLanguages = ['en', 'fr']
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('choice_self_translation', true)
            ->setDefault('choice_loader', function (Options $options): ChoiceLoaderInterface {
                return ChoiceList::loader(
                        $this,
                        new IntlCallbackChoiceLoader(
                            function (): array {
                                $languagesList = [];
                                foreach ($this->supportedLanguages as $alpha2Code) {
                                    try {
                                        $languagesList[$alpha2Code] = Languages::getName($alpha2Code, $alpha2Code);
                                    } catch (MissingResourceException $e) {
                                        // ignore errors like "Couldn't read the indices for the locale 'meta'"
                                    }
                                }

                                return array_flip($languagesList);
                            }
                        )
                    );
            }
            );
    }

    public function getParent()
    {
        return LanguageType::class;
    }
}
