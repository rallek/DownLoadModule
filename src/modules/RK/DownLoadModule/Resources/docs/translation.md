# TRANSLATION INSTRUCTIONS

To create a new translation follow the steps below:

1. First install the module like described in the `install.md` file.
2. Open a console and navigate to the Zikula root directory.
3. Execute this command replacing `en` by your desired locale code:

`php app/console translation:extract en --bundle=RKDownLoadModule --enable-extractor=jms_i18n_routing --output-format=po`

You can also use multiple locales at once, for example `de fr es`.

4. Translate the resulting `.po` files in `modules/RK/DownLoadModule/Resources/translations/` using your favourite Gettext tooling.

For questions and other remarks visit our homepage http://oldtimer-ig-osnabrueck.de.

Ralf Koester (ralf@familie-koester.de)
http://oldtimer-ig-osnabrueck.de
