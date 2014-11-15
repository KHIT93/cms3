<?php

/**
 * @file Class used to create instances of different content types
 */
class ContentType {
    private $_ctid, $_title, $_fields;
    public function __construct($ctid) {
        $data = DB::getInstance()->get('content_types', array('ctid', '=', $ctid))->first();
        $this->_ctid = $ctid;
        $this->_title = $data['title'];
        $this->_fields = json_decode($data['fields'], true);
    }
    public function updateContentType($title, $fields = array()) {
        //Update the current content type
    }
    public function deleteContentType() {
        //Delete the current content type
    }
    public static function create($ctid, $title, $fields = array()) {
        //Create a new content type
        $db = DB::getInstance();
        $data = array(
            'ctid' => $ctid,
            'title' => $title,
            'fields' => json_encode($fields)
        );
        if(!$db->insert('content_types', $data)) {
            System::addMessage('error', t('There was an error creating the content type'));
        }
        else {
            System::addMessage('success', t('The new content type <i>@contentType</i> has been created', array('@contentType' => $title)));
        }
    }
    public static function route() {
        
    }
}
