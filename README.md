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
$ composer require bantenprov/pendaftaran-wizard:dev-single
```

- Latest release:

```bash
$ composer require bantenprov/pendaftaran-wizard
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/pendaftaran-wizard.git
```

### install module :

```bash
composer require bantenprov/vue-workflow:dev-master
```

### edit `config/app.php` ( vue-workflow )
```php
'providers' => [
        Emadadly\LaravelUuid\LaravelUuidServiceProvider::class,
        Bantenprov\VueWorkflow\VueWorkflowServiceProvider::class,
```

### artisan command ( vue-workflow )
```bash
php artisan vendor:publish --provider="Emadadly\LaravelUuid\LaravelUuidServiceProvider"
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
#### Edit route : `resources/assets/js/routes.js` :
 

```javascript
function layout(name) {
  return function(resolve) {
    require(['../layouts/' + name + '.vue'], resolve);
  }
}

export default ({ authGuard, guestGuard }) => [

  {
    path: '/',
    name: 'home',
    component: resolve => require(['~/components/views/Home.vue'], resolve),
    meta: {
      title: "Tanara"
    }
  },

  // Authenticated routes.
  ...authGuard([
    {
      path: '/profile',
      component: layout('Default'),
      children: [
        {
          path: '/profile',
          name: 'profile',
          components: {
            main: resolve => require(['~/components/views/Profile.vue'], resolve),
            navbar: resolve => require(['~/components/Navbar.vue'], resolve),
            sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "Profile"
          }
        }
      ]
    },
    {
      path: '/settings',
      name: 'settings',
      redirect: '/settings/user-profile',
      component: layout('Default'),
      children: [
        {
          path: '/settings/user-profile',
          name: 'settings.user-profile',
          components: {
            main: resolve => require(['~/components/views/settings/UserProfile.vue'], resolve),
            navbar: resolve => require(['~/components/Navbar.vue'], resolve),
            sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "Profile Settings"
          }
        },
        {
          path: '/settings/user-password',
          name: 'settings.user-password',
          components: {
            main: resolve => require(['~/components/views/settings/UserPassword.vue'], resolve),
            navbar: resolve => require(['~/components/Navbar.vue'], resolve),
            sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "Change Password"
          }
        }
      ]
    },
    {
      path: '/dashboard',
      component: layout('Default'),
      children: [
        {
          path: '/dashboard',
          name: 'siswa.pendaftaran-wizard',
          components: {
            main: resolve => require(['~/components/bantenprov/pendaftaran-wizard/PendaftaranWizard.add.vue'], resolve),
            navbar: resolve => require(['~/components/Navbar.vue'], resolve),
            sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "Formulir Pendaftaran"
          }
        },
        {
          path: '/dashboard/formulir-pendaftaran',
          components: {
            main: resolve => require(['~/components/bantenprov/pendaftaran-wizard/PendaftaranWizard.add.vue'], resolve),
            navbar: resolve => require(['~/components/Navbar.vue'], resolve),
            sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
          },
          meta: {
              title: "Formulir Pendaftaran"
          }
        }
      ]
    },
  ]),

  // Guest routes.
  ...guestGuard([
    {
      path: '/login',
      name: 'login',
      component: resolve => require(['~/components/views/auth/Login.vue'], resolve),
      meta: {
        title: "Log In"
      }
    },
    {
      path: '/register',
      name: 'register',
      component: resolve => require(['~/components/views/auth/Register.vue'], resolve),
      meta: {
        title: "Register"
      }
    },
    {
      path: '/password/reset',
      name: 'password.request',
      component: resolve => require(['~/components/views/auth/password/Email.vue'], resolve),
      meta: {
        title: "Reset Password"
      }
    },
    {
      path: '/password/reset/:token',
      name: 'password.reset',
      component: resolve => require(['~/components/views/auth/password/Reset.vue'], resolve),
      meta: {
        title: "Reset Password"
      }
    }
  ]),

  {
    path: '*',
    name: 'errors.404',
    component: resolve => require(['~/components/views/errors/404.vue'], resolve),
    meta: {
      title: "Page Not Found"
    }
  }
]

```
#### Edit menu `resources/assets/js/menu.js`
 

```javascript
// childType: 'collapse|dropdown|dropup'

const MenuItems = [
  {
    name: 'Home',
    link: '/',
    icon: 'fa fa-home'
  },
  {
    name: 'Siswa',
    icon: 'fa fa-user',
    childType: 'collapse',
    childItem: [
      {
        name: 'Formulir Pendaftaran',
        link: '/dashboard',
        icon: 'fa fa-angle-double-right'
      }
    ]
  },
];

export default MenuItems;

```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//== Pendaftaran Wizard
 
import PendaftaranWizardAdminShow from './components/bantenprov/pendaftaran-wizard/PendaftaranWizardAdmin.show.vue';
Vue.component('admin-view-pendaftaran-wizard-tahun', PendaftaranWizardAdminShow);

 

