<?php

require_once __DIR__ . '/../../FPDF/fpdf.php';


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

        // Get the iterator for the beneficiary's needs
        $needsIterator = $beneficiary->getIterator();

        // Registered Needs
        if ($needsIterator->hasNext()) {
            echo '<div class="registered-needs">';
            echo '<h3 class="section-heading">Registered Needs</h3>';

            // Use the iterator to traverse the needs
            while ($needsIterator->hasNext()) {
                $need = $needsIterator->next();
                echo '<div class="need-card">';

                // Get the need type (e.g., "CashNeed" -> "cash")
                $needType = strtolower((new ReflectionClass($need))->getShortName());
                $needType = preg_replace('/need$/i', '', $needType); // Remove the "need" suffix
                echo '<h2 style="color: green;">' . htmlspecialchars(ucfirst($needType)) . '</h2>';

                // Append "needhistory" to the need type for form actions
                $needType .= 'needhistory';

                // Display need details
                echo '<p><strong>Amount:</strong> ' . htmlspecialchars($need->getAmount()) . '</p>';
                echo '<p><strong>Register Date:</strong> ' . htmlspecialchars($need->getRegisterDate()) . '</p>';
                echo '<p><strong>Purpose:</strong> ' . htmlspecialchars($need->getPurpose()) . '</p>';

                // Display status and actions based on allocation and acceptance
                if (!$need->isAllocated()) {
                    if (!$need->isAccepted()) {
                        echo '<div class="need-card" style="border: 2px solid red;">';
                        echo '<p><strong>Status:</strong> Beneficier need Rejected ❌</p>';
                        echo '</div>'; // Close card

                        echo '<form method="POST" action="index.php?action=register_need" class="action-form">';
                        echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($needType) . '">';
                        echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                        echo '<input type="hidden" name="amount" value="' . htmlspecialchars($need->getAmount()) . '">';
                        echo '<button type="submit" class="btn-secondary">Reapply</button>';
                        echo '</form>';
                    } else {
                        echo '<div class="need-card" style="border: 1px solid gold;">';
                        echo '<p><strong>Status:</strong> Beneficier need Approved Pending Support... </p>';
                        echo '</div>'; // Close card

                        echo '<form method="POST" action="index.php?action=allocate_resources" class="action-form">';
                        echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($needType) . '">';
                        echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                        echo '<input type="hidden" name="allocation_id" value="' . htmlspecialchars($need->getAllocationID()) . '">';
                        echo '<button type="submit" class="btn-secondary">Allocate Resources</button>';
                        echo '</form>';
                    }
                    echo '<form method="POST" action="index.php?action=remove_need" class="action-form">';
                    echo '<input type="hidden" name="need_type" value="' . htmlspecialchars($needType) . '">';
                    echo '<input type="hidden" name="beneficiary_id" value="' . htmlspecialchars($beneficiary->getPersonID()) . '">';
                    echo '<input type="hidden" name="AllocationID" value="' . htmlspecialchars($need->getAllocationID()) . '">';
                    echo '<button type="submit" class="btn-danger">Remove Need</button>';
                    echo '</form>';
                } else {
                    echo '<div class="need-card" style="border: 1px solid green;">';
                    echo '<p><strong>Status:</strong> Allocated✅</p>';
                    echo '</div>'; // Close card

                    // Generate and display the PDF download link
                    $logoPath = '../web_logo.jpg'; // Path to your logo
                    $pdfFilePath = $this->generateNeedAllocationPDF($need, $beneficiary, $logoPath);

                    echo '<div class="pdf-download">';
                    echo '<a href="' . $pdfFilePath . '" class="btn btn-primary" download style="text-decoration: none;">Download Allocation Details</a>';
                    echo '</div>';
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





    public function generateNeedAllocationPDF($need, $beneficiary, $logoPath)
    {
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font for the entire document
        $pdf->SetFont('Arial', '', 12);

        // Add header with logo and title
        $pdf->Image($logoPath, 150, 10, 50); // Slightly bigger logo, positioned at the top right
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(33, 37, 41); // Dark gray text
        $pdf->Cell(0, 15, 'Need Allocation Report', 0, 1, 'C');
        $pdf->Ln(50); // Reduced spacing

        // Beneficiary Information Section
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(52, 58, 64); // Dark header background
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->Cell(0, 8, 'Beneficiary Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(33, 37, 41); // Reset to dark gray text

        // Beneficiary details table
        $pdf->SetFillColor(245, 245, 245); // Light gray for rows
        $pdf->Cell(50, 8, 'Name:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $beneficiary->getFirstName() . ' ' . $beneficiary->getLastName(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Beneficiary ID:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $beneficiary->getPersonID(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Phone:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $beneficiary->getPhone(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Income:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $beneficiary->getIncome(), 1, 1, 'L');

        $pdf->Ln(20);

        // Need Information Section
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(52, 58, 64); // Dark header background
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->Cell(0, 8, 'Need Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(33, 37, 41); // Reset to dark gray text

        // Need details table
        $pdf->SetFillColor(245, 245, 245); // Light gray for rows
        $pdf->Cell(50, 8, 'Type:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, get_class($need), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Amount:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $need->getAmount(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Purpose:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $need->getPurpose(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Register Date:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $need->getRegisterDate(), 1, 1, 'L');
        $pdf->Cell(50, 8, 'Status:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, 'Allocated', 1, 1, 'L');

        // Ensure the directory exists
        $directory = 'Server Documents';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); // Create the directory with full permissions
        }

        // Save the PDF to a file
        $pdfFilePath = $directory . '/' . $beneficiary->getFirstName() . '_' . $beneficiary->getLastName() . '_' . get_class($need) . '_' . $need->getAllocationID() . '.pdf';
        $pdf->Output('F', $pdfFilePath);

        return $pdfFilePath;
    }
}
