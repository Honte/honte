<?php
/**
 * @property Navigation $Navigation
 */
class AppController extends Controller {
	
	var $components = array('Session', 'Email', 'json', 'Cookie', 'DebugKit.Toolbar');
	var $helpers = array('Form', 'Html', 'Javascript', 'Session', 'LedCommon.Image', 'Calendar', 'Board', 'Time', 'Go', 'LedCommon.Common', 'LedCommon.Navigation');
	var $uses = array('Navigation', 'Page');
	
	var $pageTitle = 'Honte';

    var $admin_navigation = 'home_nav';
    var $rss_channel = array(
        'WOG Artykuły' => array('controller' => 'articles', 'action' => 'rss'),
//        'WOG Gry' => array('controller' => 'ladder', 'action' => 'rss'),
    );
    var $description = 'Informacje o spotkaniach poznańskiego klubu Go a także o wydarzeniach goistycznych odbywających się w całej Polsce.';
	var $sidebars = array(
	    'fb',
		'meeting',
		'events',
        'recent',
        'contact',
        'ads'
        );

    var $last_breadcrumbs = array();
    var $breadcrumbs = array(array(
				'anchor' => 'Strona główna',
				'link' => '/'
			));

	var $paginationLimit = 50;
    var $frontPaginationLimit = 15;
    var $current = 'klub';
	
	function beforeFilter() {

		if(!empty($this->params['prefix'])) {
			
			$this->layout = $this->params['prefix'];
			
			if (!$this->Session->check('User') && ($this->action != 'admin_login' && $this->action != 'admin_logout')) {
				
				$this->redirect('/admin/logout');	
			}
		}
	}

    function addBreadcrumb($bread) {       
        $this->breadcrumbs []= (array)$bread;
    }

	function beforeRender() {

        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->set('admin_navigation', $this->admin_navigation);
        }

        $page_title = explode(' : ', $this->pageTitle);
        $page_title = (count($page_title) > 1) ? $page_title[1] : $page_title[0];

        $this->set('contactPage', $this->Page->findByLabel('contact'));
		$this->set('referer', $this->referer());
		$this->set('breadcrumbs_for_layout', $this->breadcrumbs);
		$this->set('current', $this->current);
		$this->set('title_for_layout', $this->pageTitle);
		$this->set('sidebar_for_layout', $this->sidebars);
		$this->set('description_for_layout', $this->description);
		$this->set('rss_channel', $this->rss_channel);
	}


    /* sidebar function */

    function sidebarAppend($new) {
        array_push($this->sidebars, $new);
    }

    function sidebarRemove($old) {
        $index = array_search($old, $this->sidebars);
        if ($index !== false) {
            array_splice($this->sidebars, $index, 1);
            return true;
        } else {
            return false;
        }
    }

    function sidebarReplace($old, $new) {
        $index = array_search($old, $this->sidebars);
        if ($index !== false) {
            $this->sidebars[$index] = $new;
            return true;
        } else {
            return false;
        }
    }

    function sidebarInsert($new) {
        $this->sidebars = array_merge((array)$new, $this->sidebars);
    }

    protected function sendMail($data = false) {

		$this->Email->_newLine = "\n";

		if (!isset($data['from']) || !isset($data['content']))
			return false;

		$this->Email->from = $data['from'];

		if(isset($data['to']))
			$this->Email->to = $data['to'];
		else
			$this->Email->to = 'some@backup.email';

		if(isset($data['replyTo']))
			$this->Email->replyTo = $data['replyTo'];
		else
			$this->Email->replyTo = $data['from'];

		if(isset($data['subject']))
			$this->Email->subject = $data['subject'];
		else
			$this->Email->subject = 'Wiadomość od Honte';

		if(isset($data['cc']))
			$this->Email->cc = $data['cc'];

		if(isset($data['bcc']))
			$this->Email->bcc = $data['bcc'];

		if(isset($data['template']))
			$this->Email->template = $data['template'];
		else
			$this->Email->template = 'default';


		$this->Email->sendAs = 'html';
		$this->set('data', $data['content']);

	   /* SMTP Options */
	   $this->Email->smtpOptions = Configure::read('smtp');

		/* Set delivery method */
		$this->Email->delivery = 'smtp';


		if($this->Email->send())
			return true;
		else
			return false;
	}

    /**
     * @param string $slack_msg Message to deliver, supports slack markdown
     * @param string $slack_channel Channel where the notification will be delivered
     */
    protected function notify_slack($slack_msg, $username, $slack_channel = "")
    {
        $url = Configure::read('Slack_webhook');
        if (!$url) return; // slack not configured, skip notification

        $options = array(
            'http' => array(
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'timeout' => 0.5,
                'content' => "{ \"text\": \"" . $slack_msg . "\", \"username\": \"" . $username . "\" " . ($slack_channel ? ", \"channel\": \"" . $slack_channel . "\"" : "") . "}"
            )
        );
        $context = stream_context_create($options);
        try {
            $result = file_get_contents($url,false, $context);
            // ignore output, it's only a notify
        } catch (Exception $ex) {
            // ignore, it's only a notify
        }
    }

}