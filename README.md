# pendaftaran-wizard

[![Join the chat at https://gitter.im/pendaftaran-wizard/Lobby](https://badges.gitter.im/pendaftaran-wizard/Lobby.svg)](https://gitter.im/pendaftaran-wizard/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/pendaftaran-wizard/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/pendaftaran-wizard/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/pendaftaran-wizard/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/pendaftaran-wizard/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/pendaftaran-wizard/v/stable)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)
[![Total Downloads](https://poser.pugx.org/bantenprov/pendaftaran-wizard/downloads)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/pendaftaran-wizard/v/unstable)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)
[![License](https://poser.pugx.org/bantenprov/pendaftaran-wizard/license)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/pendaftaran-wizard/d/monthly)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)
[![Daily Downloads](https://poser.pugx.org/bantenprov/pendaftaran-wizard/d/daily)](https://packagist.org/packages/bantenprov/pendaftaran-wizard)


### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/pendaftaran-wizard:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/pendaftaran-wizard
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/pendaftaran-wizard.git
```

### install node module :

<a href="http://momentjs.com/timezone/"> moment-timezone </a>
```
npm install moment-timezone --save
```

<a href="https://www.npmjs.com/package/vue-momentjs"> vue-momentjs </a>
```
npm i vue-momentjs
```

<a href="https://github.com/brockpetrie/vue-moment"> vue-moment </a>
```
npm install --save vue-moment
```

#### Edit `config/app.php` :

```php
'providers' => [

    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //....
    Bantenprov\PendaftaranWizard\PendaftaranWizardServiceProvider::class,
```


#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=pendaftaran-wizard-assets
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :
 

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/pendaftaran-wizard/create',
            name: 'pendaftaran-wizard',
            components: {
                main: resolve => require(['./components/bantenprov/pendaftaran-wizard/PendaftaranWizard.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Formulir Pendaftaran"
            }
        },
         
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`
 

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
        name: 'Formulir Pendaftaran',
        link: '/admin/pendaftaran-wizard/create',
        icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//== Pendaftaran Wizard
 
import PendaftaranWizardAdminShow from './components/bantenprov/pendaftaran-wizard/PendaftaranWizardAdmin.show.vue';
Vue.component('admin-view-pendaftaran-wizard-tahun', PendaftaranWizardAdminShow);

 

