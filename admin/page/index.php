<?php

/**
 * Created by Konstantin Kolodnitsky
 * Date: 25.11.13
 * Time: 14:57
 */
class page_index extends Page {

    public $title='Dashboard';

    function init() {
        parent::init();
        $this->add('View_Box')
            ->setHTML('Welcome to SMTP Chceker. Type in details of your SMTP server and we will send a test-mail');

    }

}
