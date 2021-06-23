<?php
namespace local_aaviewreports;
require_once(__DIR__ . '/../../../config.php');

// Class moodleform is defined in formslib.php.
require_once("$CFG->libdir/formslib.php");


class aaviewreports_form extends \moodleform
{
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'email', get_string('email')); // Add elements to your form.
        $mform->setType('email', PARAM_NOTAGS);                   // Set type of element.
        $mform->setDefault('email', 'Please enter email');        // Default value.

        $mform->addElement('checkbox', 'ratingtime', get_string('ratingtime', 'local_helloworld'));
        $mform->addElement('button', 'intro', get_string("buttonlabel", 'local_helloworld'));

    }

    // Custom validation should be added here.
    public function validation($data, $files) {
        return array();
    }
}