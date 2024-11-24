<?php

class Beneficiary_Profile_View
{
    public function showBeneficiary($beneficiary)
    {
        echo '<link rel="stylesheet" type="text/css" href="Views/styles/profile.css">';

        echo '<div class="profile-dashboard">';
        echo '<h1>Beneficiary Profile</h1>';

        // Personal Information Section
        echo '<div class="profile-section">';
        echo '<h2 class="section-heading">Personal Information</h2>';
        echo '<div class="profile-info-grid">';
        echo '<div class="info-item"><span class="label">Name:</span> ' . htmlspecialchars($beneficiary->getFirstName() . ' ' . $beneficiary->getMiddleName() . ' ' . $beneficiary->getLastName()) . '</div>';
        echo '<div class="info-item"><span class="label">Phone:</span> ' . htmlspecialchars($beneficiary->getPhone()) . '</div>';
        echo '<div class="info-item"><span class="label">Income:</span> ' . htmlspecialchars($beneficiary->getIncome()) . '</div>';
        echo '<div class="info-item"><span class="label">Disability:</span> ' . ($beneficiary->hasDisability() ? 'Yes' : 'No') . '</div>';
        echo '<div class="info-item"><span class="label">Homeless:</span> ' . ($beneficiary->isHomeless() ? 'Yes' : 'No') . '</div>';
        echo '<div class="info-item"><span class="label">Chronic Disease:</span> ' . ($beneficiary->hasChronicDisease() ? 'Yes' : 'No') . '</div>';
        echo '<div class="info-item"><span class="label">Nationality:</span> ' . htmlspecialchars($beneficiary->getNationality()) . '</div>';
        echo '<div class="info-item"><span class="label">Gender:</span> ' . htmlspecialchars($beneficiary->getGender()) . '</div>';
        echo '<div class="info-item"><span class="label">Beneficiary ID:</span> ' . htmlspecialchars($beneficiary->getPersonID()) . '</div>';
        echo '</div>';
        echo '</div>';

        // Needs Section
        echo '<div class="needs-section">';
        echo '<h2 class="centered-heading">Needs</h2>';

        // Registered Needs
        if (!empty($beneficiary->getNeeds())) {
            echo '<div class="registered-needs">';
            echo '<h3 class="section-heading">Registered Needs</h3>';
            foreach ($beneficiary->getNeeds() as $need) {
                echo '<div class="need-card">';
                $needType = explode('needhistory', $need['table_name'])[0];
                echo '<p><strong>' . htmlspecialchars(strtoupper($needType)) . '</strong></p>';
                echo '<p><strong>Amount:</strong> ' . htmlspecialchars($need['Amount']) . '</p>';
                echo '<p><strong>Register Date:</strong> ' . htmlspecialchars($need['RegisterDate']) . '</p>';
                echo '<p><strong>Purpose:</strong> ' . htmlspecialchars($need['purpose']) . '</p>';


                if (!$need['Allocated']) {
                    if (!$need['Accepted']) {
                        echo '<div class="need-card" style="border: 2px solid red;">';
                        echo '<p><strong>Status:</strong> Beneficier need Rejected ❌</p>';

                        echo '</div>'; // Close card

                        echo '<form method="POST" action="index.php?action=register_need" class="action-form">';
                        echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($needType) . '">';
                        echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                        echo '<input type="hidden" name="amount" value="' . htmlspecialchars($need['Amount']) . '">';
                        echo '<button type="submit" class="btn-secondary">Reapply</button>';
                        echo '</form>';
                    } else {
                        echo '<div class="need-card" >';
                        echo '<p><strong>Status:</strong> Beneficier need Approved Pending Support... </p>';
                        echo '</div>'; // Close card

                        echo '<form method="POST" action="index.php?action=allocate_resources" class="action-form">';
                        echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($need['table_name']) . '">';
                        echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                        echo '<button type="submit" class="btn-secondary">Allocate Resources</button>';
                        echo '</form>';
                    }
                    echo '<form method="POST" action="index.php?action=remove_need" class="action-form">';
                    echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($need['table_name']) . '">';
                    echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                    echo '<input type="hidden" name="AllocationID" value="' . htmlspecialchars($need['AllocationID']) . '">';
                    echo '<button type="submit" class="btn-danger">Remove Need</button>';
                    echo '</form>';
                } else {
                    echo '<div class="need-card" >';
                    echo '<p><strong>Status:</strong> Allocated✅</p>';
                    echo '</div>'; // Close card
                }

                echo '</div>'; // Close need-card
            }
            echo '</div>';
        } else {
            echo '<div class="need-card">';
            echo '<p>Beneficier has no needs registered</p>';
            echo '</div>'; // Close card
        }

        // Available Needs
        echo '<div class="available-needs">';
        echo '<br>';
        echo '<h3 class="section-heading">Register New Beneficiary Need</h3>';
        $allNeeds = ['Cash', 'Food', 'Clothing', 'Shelter', 'Drug', 'Medical'];
        foreach ($allNeeds as $need) {
            echo '<div class="need-card">';
            echo '<form method="POST" action="index.php?action=register_need">';
            echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($need) . '">';
            echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
            echo '<label><strong>' . htmlspecialchars($need) . ':</strong></label>';
            if ($need === 'Shelter' || $need === 'Medical') {
                echo '<input type="hidden" name="amount" value="1">';
                echo '<button type="submit" class="btn-primary">Request</button>';
            } else {
                echo '<input type="number" name="amount" required>';
                echo '<button type="submit" class="btn-primary">Request</button>';
            }
            echo '</form>';
            echo '</div>';
        }
        echo '</div>'; // Close available-needs

        echo '</div>'; // Close needs-section

        echo '</div>'; // Close profile-dashboard
    }
}
