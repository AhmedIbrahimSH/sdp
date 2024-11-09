<?php
class VolunteerController {
    private $volunteerModel;

    public function __construct($volunteerModel) {
        $this->volunteerModel = $volunteerModel;
    }

    public function index() {
        $volunteers = $this->volunteerModel->getAllVolunteers();
        include 'views/volunteer_list.php';
    }

    public function show($id) {
        $volunteer = $this->volunteerModel->getVolunteerById($id);
        include 'views/volunteer_detail.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'joined_date' => $_POST['joined_date'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->volunteerModel->createVolunteer($data);
            header("Location: index.php?action=index");
            exit;
        } else {
            include 'views/volunteer_create.php';
        }
    }


    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data and update volunteer
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'joined_date' => $_POST['joined_date'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->volunteerModel->updateVolunteer($id, $data);
            header("Location: index.php?action=index");
        } else {
            // Display the form with current volunteer data
            $volunteer = $this->volunteerModel->getVolunteerById($id);
            include 'views/volunteer_edit.php';
        }
    }

    public function delete($id) {
        $this->volunteerModel->deleteVolunteer($id);
        header("Location: /volunteers");
    }
}
?>
