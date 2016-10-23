<?php
namespace Concrete\Package\Amp\Controller\SinglePage\Dashboard\System\Seo;

use Core;
use Package;
use PageType;

class Amp extends \Concrete\Core\Page\Controller\DashboardPageController
{
    public function view()
    {
        /** @var \Concrete\Core\Package\Package $pkg */
        $pkg = Package::getByHandle('amp');
        $account = $pkg->getFileConfig()->get('analytics.googleanalytics.account');
        $this->set('account', $account);

        $selectedTypes = $pkg->getFileConfig()->get('types');
        $this->set('types', $selectedTypes);

        $ptIDs = array();
        $pagetypes = PageType::getList();
        /** @var PageType $pt */
        foreach ($pagetypes as $pt) {
            $ptIDs[$pt->getPageTypeID()] = $pt->getPageTypeDisplayName();
        }
        $this->set('pagetypes', $ptIDs);

        $this->requireAsset('select2');

        $this->set('pageTitle', t('Accelerated Mobile Pages (AMP)'));
    }

    public function settings_saved()
    {
        $this->set('message', t('Settings saved.'));
        $this->view();
    }

    public function update_settings()
    {
        if ($this->token->validate("update_settings")) {
            if ($this->isPost()) {
                /** @var \Concrete\Core\Package\Package $pkg */
                $pkg = Package::getByHandle('amp');
                $pkg->getFileConfig()->save('analytics.googleanalytics.account', $this->post('account'));
                if (is_array($this->post('types'))) {
                    $pkg->getFileConfig()->save('types', $this->post('types'));
                }
                $this->redirect('/dashboard/system/seo/amp', 'settings_saved');
            }
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
        $this->view();
    }
}
