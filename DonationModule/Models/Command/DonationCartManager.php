<?php

namespace DonationModule\Models\Command;
//require_once ('IDonationCommand.php');
//This is the invoker class where it should set the command and call  execute()

class DonationCartManager
{
    private IDonationCommand $currentCommand ; // Command slot
    private $undoStack = [];
    private $redoStack = [];
    public function __construct()
    {

    }
    public function setCommand($command)
    {

        $this->currentCommand=$command;
        $this->currentCommand->execute();
        $this->undoStack[] = $this->currentCommand; // Add to undo stack
        $this->redoStack = []; // Clear redo stack after a new command

    }
    public function getCommand()
    {
    return $this->currentCommand;
    }
    public function undoButtonPressed()
    {
        if (!empty($this->undoStack)) {
            $this->currentCommand = array_pop($this->undoStack); // Pop from undo stack
            $this->currentCommand->undo(); // Undo the command
            $this->redoStack[] = $this->currentCommand; // Push to redo stack
        }
        else {
            //echo "Nothing to undo.";
        }
    }
    public function redoButtonPressed()
    {
        if (!empty($this->redoStack)) {
            $this->currentCommand= array_pop($this->redoStack); // Pop from redo stack
            $this->currentCommand->execute(); // Redo (execute again)
            $this->undoStack[] =  $this->currentCommand; // Push back to undo stack
        } else {
           // echo "Nothing to redo." . PHP_EOL;
        }

    }











    public function addDonation()
    {

    }
    public function removeDonation()
    {

    }


}