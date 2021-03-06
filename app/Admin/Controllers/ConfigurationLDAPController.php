<?php

namespace App\Admin\Controllers;

use Adldap\Auth\BindException;
use Adldap\Auth\PasswordRequiredException;
use Adldap\Auth\UsernameRequiredException;
use App\Admin\Forms\ConfigurationLDAPForm;
use App\Http\Controllers\Controller;
use App\Support\LDAP;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

class ConfigurationLDAPController extends Controller
{
    /**
     * 页面
     * @param Content $content
     * @return Content
     */
    public function index(Content $content): Content
    {
        return $content
            ->title(admin_trans_label('LDAP'))
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $tab = new Tab();
                $tab->addLink('平台', route('configurations.platform.index'));
                $tab->addLink('扩展', route('configurations.extensions.index'));
                $tab->add('LDAP', new ConfigurationLDAPForm(), true);
                $row->column(12, $tab->withCard());
            });
    }

    /**
     * AD登录验证
     * @return bool|string
     */
    public function test()
    {
        try {
            if (!admin_setting('ad_enabled')) {
                return -3;
            }
            return LDAP::auth();
        } catch (BindException $e) {
            return $e->getMessage();
        } catch (PasswordRequiredException $e) {
            return -1;
        } catch (UsernameRequiredException $e) {
            return -2;
        }
    }
}
