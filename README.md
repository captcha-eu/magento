
# Captcha.eu

## Magento 2 Install

```bash
# install composer package
composer require captcha-eu/magento;

# enable module
php bin/magento module:enable CaptchaEU_Captcha;

# upgrade setup
php bin/magento setup:upgrade;
```

## Obtain REST-Key & Public-Key
 - Go to [https://www.captcha.eu/login](www.captcha.eu/login) and signup
 - After signup go to domains and add a new domain.
 - When done, you'll get the Rest-Key and Public Key

Head back to your Adobe Commerce / Magento 2 admin interface and enter both keys under `STORES -> Configuration -> Captcha.eu`

