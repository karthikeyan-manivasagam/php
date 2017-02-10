<?php

class SomeMediatorbetweenTwoperson {
   private $maleObject;
    private $femaleObject;
    function __construct($malename_in, $femalename_in) {
      $this->maleObject = new Male($malename_in,$this);
      $this->femaleObject  = new Female($femalename_in,$this);
    }
    function getMale() {return $this->maleObject;}
    function getFemale() {return $this->femaleObject;}
    // when title or author change case, this makes sure the other
    // stays in sync
    function change(HumanDefiner $changingClassIn) {
      if ($changingClassIn instanceof Male) {
        if ('single' == $changingClassIn->getStatus()) {
          if ('single' != $this->getFemale()->getStatus()) {
            $this->getFemale()->setFemalePersonSingle();
          }
        } elseif ('committed' == $changingClassIn->getStatus()) {
          if ('committed' != $this->getFemale()->getStatus()) {
            $this->getFemale()->setFemalePersonCommitted();
          }
        }
      } elseif ($changingClassIn instanceof Female) {
        if ('single' == $changingClassIn->getStatus()) {
          if ('single' != $this->getMale()->getStatus()) {
            $this->getMale()->setMalePersonSingle();
          }
        } elseif ('committed' == $changingClassIn->getStatus()) {
          if ('committed' != $this->getMale()->getStatus()) {
            $this->getMale()->setMalePersonCommitted();
          }
        }
      }
    }
}


abstract class HumanDefiner {
	private $mediator;
    function __construct($mediator_in) {
        $this->mediator = $mediator_in;
    }
    function getMediator() {return $this->mediator;}
}


class Male extends HumanDefiner {
    private $name;
    private $status;
    function __construct($name_in, $mediator_in) {
      $this->name = $name_in;
      parent::__construct($mediator_in);
    }
    function getMaleName() {return $this->name;}

    function setMaleName($name_in) {$this->name = $name_in;}

    function getStatus() {return $this->status;}


    function setStatus($status_in) {$this->status = $status_in;}


    function setMalePersonSingle() {
      $this->setMaleName($this->getMaleName());
      $this->setStatus('single');
      $this->getMediator()->change($this);
    }

    function setMalePersonCommitted() {
      $this->setMaleName($this->getMaleName());
      $this->setStatus('committed');
      $this->getMediator()->change($this);
    }
}


class Female extends HumanDefiner {
    private $name;
    private $status;
    function __construct($name_in, $mediator_in) {
      $this->name = $name_in;
      parent::__construct($mediator_in);
    }
    function getFemaleName() {return $this->name;}

    function setFemaleName($name_in) {$this->name = $name_in;}

    function getStatus() {return $this->status;}


    function setStatus($status_in) {$this->status = $status_in;}


    function setFemalePersonSingle() {
      $this->setFemaleName($this->getFemaleName());
      $this->setStatus('single');
      $this->getMediator()->change($this);
    }

    function setFemalePersonCommitted() {
      $this->setFemaleName($this->getFemaleName());
      $this->setStatus('committed');
      $this->getMediator()->change($this);
    }
}




$mediator = new SomeMediatorbetweenTwoperson('jack', 'rose' );
 
  $male = $mediator->getMale();
  $female = $mediator->getFemale();
 
  writeln('Orginal name and status note status is empty');

  writeln('male: ' . $male->getMaleName());
  writeln('female: ' . $female->getFemaleName());

 
  writeln('male status: ' . $male->getStatus());
  writeln('female status: ' . $female->getStatus());
      echo '<br/>';
  $male->setMalePersonSingle();

   writeln('After setting male to single female also changed, note We changed only male status');

  writeln('male status: ' . $male->getStatus());
  writeln('female status: ' . $female->getStatus());

    echo '<br/>';
  $female->setFemalePersonCommitted();

  writeln('After setting female to committed male also changed, note We changed only female status ');
  writeln('male status: ' . $male->getStatus());
  writeln('female status: ' . $female->getStatus());
  writeln('');
 
  function writeln($line_in) {
    echo $line_in.'<br/>';

  }