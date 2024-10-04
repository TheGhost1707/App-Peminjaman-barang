<?php
session_start();

// Misalkan session nama admin disimpan saat login
// $_SESSION['admin_name'] = 'Nama Admin'; // Ini biasanya diset pada saat login

// Cek apakah session admin_name ada
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin Name';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requestment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        /* Set the content area to A4 size */
        #contentToPrint {
            width: 210mm;
            min-height: 297mm;
            padding: 20px;
            margin: auto;
            background: white;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #contentToPrint,
            #contentToPrint * {
                visibility: visible;
            }

            #contentToPrint {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: auto;
                border: none;
            }

            .no-print {
                display: none;
            }
        }

        .signature {
            padding-top: 20px;
            margin-top: 100px;
            display: flex;
            justify-content: space-between;
            margin: 100px;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        table {
            table-layout: fixed;
        }
    </style>
</head>

<body>
    <div class="main-panel">
        <div class="content-wrapper" id="contentToPrint">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard_adm.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Requestment</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center mb-4">
                <img src="../assets/images/logo.png" alt="Company Logo" style="width: 200px;">
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <button class="btn btn-primary no-print" onclick="printToPDF()">Print to PDF</button>
                        <div class="card-body">
                            <h4 class="card-title">Request List</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Request Name</th>
                                        <th>Division</th>
                                        <th>Project Location</th>
                                        <th>Quantity</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('../connection.php'); // Koneksi ke database

                                    $query = "SELECT l.*, i.item_name FROM loans l JOIN items i ON l.item_id = i.item_id ORDER BY l.created_at DESC";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        $no = 1; // Untuk nomor urut
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>"; // No
                                            echo "<td>" . htmlspecialchars($row['item_name']) . "</td>"; // Item Name
                                            echo "<td>" . htmlspecialchars($row['borrower_name']) . "</td>"; // Request Name (Borrower)
                                            echo "<td>" . htmlspecialchars($row['division']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                            echo "<td>" . intval($row['quantity']) . "</td>"; // Quantity
                                            echo "<td>" . htmlspecialchars($row['loan_date']) . "</td>"; // Borrow Date
                                            echo "<td>" . ($row['return_date'] ? htmlspecialchars($row['return_date']) : 'Not Returned Yet') . "</td>"; // Return Date
                                            echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No loan requests found</td></tr>";
                                    }

                                    // Tutup koneksi
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                            <div class="signature">
                                <div>
                                    <p>_________________________</p>
                                    <p><?php echo htmlspecialchars($name); ?></p> <!-- Nama admin dari session -->
                                </div>
                                <div>
                                    <p>_________________________</p>
                                    <p>Lab Head Name</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function printToPDF() {
            const element = document.getElementById('contentToPrint');
            const printButton = document.querySelector('.no-print'); // Select the print button

            if (!element) {
                console.error('Element tidak ditemukan');
                return;
            }

            // Hide the print button
            printButton.style.display = 'none';

            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');

            try {
                const canvas = await html2canvas(element, {
                    scale: 2, // Scale set to 2 to balance between quality and size
                    useCORS: true, // Prevent cross-origin issues
                });

                // Convert to JPEG and use quality compression
                const imgData = canvas.toDataURL('image/jpeg', 1); // Set quality to 0.7 for smaller size
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                // Add the image in parts if it exceeds the A4 size
                pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Save the PDF
                pdf.save('Report file.pdf');
            } catch (error) {
                console.error('Error generating PDF:', error);
            } finally {
                // Show the print button again after generating the PDF
                printButton.style.display = 'block';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>