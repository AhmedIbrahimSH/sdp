<?php

class UpdateBeneficiaryView
{
    public function render($beneficiary)
    {
        // Embedding the CSS file for styling
        echo '<link rel="stylesheet" type="text/css" href="Views/styles/form.css">';

        // Start the form with existing beneficiary values
        echo '<div class="form-container">';
        echo '<h1>Edit Beneficiary</h1>';

        // Form for updating beneficiary details
        echo '<form action="index.php?action=update_beneficiary&id=' . urlencode($beneficiary->getPersonID()) . '" method="POST">';

        // First Name field, pre-filled with existing value
        echo '<div class="form-group">';
        echo '<label for="firstName">First Name</label>';
        echo '<input type="text" id="firstName" name="firstName" value="' . htmlspecialchars($beneficiary->getFirstName()) . '" required>';
        echo '</div>';

        // Last Name field, pre-filled with existing value
        echo '<div class="form-group">';
        echo '<label for="lastName">Last Name</label>';
        echo '<input type="text" id="lastName" name="lastName" value="' . htmlspecialchars($beneficiary->getLastName()) . '" required>';
        echo '</div>';

        // Middle Name field, optional
        echo '<div class="form-group">';
        echo '<label for="middleName">Middle Name (optional)</label>';
        echo '<input type="text" id="middleName" name="middleName" value="' . htmlspecialchars($beneficiary->getMiddleName()) . '">';
        echo '</div>';

        // Nationality dropdown, pre-selected with the current value
        echo '<div class="form-group">';
        echo '<label for="nationality">Beneficiary Type</label>';
        echo '<select id="nationality" name="nationality" required>';
        echo '<option value="Egyptian" ' . ($beneficiary->getNationality() == 'Egyptian' ? 'selected' : '') . '>Egyptian</option>';
        echo '<option value="Foreign" ' . ($beneficiary->getNationality() == 'Foreign' ? 'selected' : '') . '>Foreign</option>';
        echo '</select>';
        echo '</div>';

        // Gender dropdown, pre-selected with the current value
        echo '<div class="form-group">';
        echo '<label for="gender">Gender</label>';
        echo '<select id="gender" name="gender" required>';
        echo '<option value="Male" ' . ($beneficiary->getGender() == 'Male' ? 'selected' : '') . '>Male</option>';
        echo '<option value="Female" ' . ($beneficiary->getGender() == 'Female' ? 'selected' : '') . '>Female</option>';
        echo '</select>';
        echo '</div>';

        // Phone Number field, pre-filled with the current value
        echo '<div class="form-group">';
        echo '<label for="phone">Phone Number</label>';
        echo '<input type="text" id="phone" name="phone" value="' . htmlspecialchars($beneficiary->getPhone()) . '" required>';
        echo '</div>';

        // Income field, pre-filled with the current value
        echo '<div class="form-group">';
        echo '<label for="income">Income</label>';
        echo '<input type="number" step="0.01" id="income" name="income" value="' . htmlspecialchars($beneficiary->getIncome()) . '" required>';
        echo '</div>';

        // Blood Type dropdown, pre-selected with the current value
        echo '<div class="form-group">';
        echo '<label for="bloodType">Blood Type</label>';
        echo '<select id="bloodType" name="bloodType" required>';
        echo '<option value="A+" ' . ($beneficiary->getBloodType() == 'A+' ? 'selected' : '') . '>A+</option>';
        echo '<option value="A-" ' . ($beneficiary->getBloodType() == 'A-' ? 'selected' : '') . '>A-</option>';
        echo '<option value="B+" ' . ($beneficiary->getBloodType() == 'B+' ? 'selected' : '') . '>B+</option>';
        echo '<option value="B-" ' . ($beneficiary->getBloodType() == 'B-' ? 'selected' : '') . '>B-</option>';
        echo '<option value="AB+" ' . ($beneficiary->getBloodType() == 'AB+' ? 'selected' : '') . '>AB+</option>';
        echo '<option value="AB-" ' . ($beneficiary->getBloodType() == 'AB-' ? 'selected' : '') . '>AB-</option>';
        echo '<option value="O+" ' . ($beneficiary->getBloodType() == 'O+' ? 'selected' : '') . '>O+</option>';
        echo '<option value="O-" ' . ($beneficiary->getBloodType() == 'O-' ? 'selected' : '') . '>O-</option>';
        echo '</select>';
        echo '</div>';

        // Chronic Disease checkbox, pre-checked if true
        echo '<div class="form-group-checkbox">';
        echo '<label for="hasChronicDisease">';
        echo '<input type="checkbox" id="hasChronicDisease" name="hasChronicDisease" ' . ($beneficiary->hasChronicDisease() ? 'checked' : '') . '>';
        echo 'Has Chronic Disease';
        echo '</label>';
        echo '</div>';

        // Disability checkbox, pre-checked if true
        echo '<div class="form-group-checkbox">';
        echo '<label for="hasDisability">';
        echo '<input type="checkbox" id="hasDisability" name="hasDisability" ' . ($beneficiary->hasDisability() ? 'checked' : '') . '>';
        echo 'Has Disability';
        echo '</label>';
        echo '</div>';

        // Homeless checkbox, pre-checked if true
        echo '<div class="form-group-checkbox">';
        echo '<label for="isHomeless">';
        echo '<input type="checkbox" id="isHomeless" name="isHomeless" ' . ($beneficiary->isHomeless() ? 'checked' : '') . '>';
        echo 'Is Homeless';
        echo '</label>';
        echo '</div>';

        // Submit button
        echo '<div class="form-group">';
        echo '<button type="submit" class="btn-submit">Update Beneficiary</button>';
        echo '</div>';

        echo '</form>';
        echo '</div>';
    }
}
