<div class="card">
    <div class="card-body">
        <h1 class="card-title">Audits Report</h1>
        <div class="d-flex justify-content-center">
            <div class="btn-group" style="margin: 14px auto 0 0; height: 40px;" role="group" aria-label="Basic example">
                <select class="form-select" id="audits_Date-criteria-select" style="margin-right: 10px;">
                    <option disabled selected>Filter Date</option>
                    <option value="ByDay">By Day</option>
                    <option value="ByMonth">By Month</option>
                    <option value="Range">Custom Range</option>
                </select>
                <!-- Audit Button  -->
                <form action="../Finance/Finance.php" method="post">
                    <?php
                    include "../Components/connection.php";

                    if (isset($_POST['Audit'])) { 
                        $sql = "Call InsertDailyAudit";
                        
                        try {
                            $query = $conn->query($sql);
                            if ($query) {
                              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              Successfully Generated Audit
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                            }  
                          } catch (\Throwable $th) {
                            //throw $th;
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Something When Wrong                            
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                          }
                        }
                    ?>
                    <input class="btn btn-outline-success" type="button" value="Generate Audit" name="Audit">
                </form>

                <input type="date" id="Audit-date-input" class="form-control" hidden style="margin-right: 10px;">
                <select class="form-select" id="Audit-month-select" hidden style="margin-right: 10px;">
                    <option disabled selected>Select Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>


                <!-- <input type="date" id="audit-start-date-input" class="form-control" hidden style="margin-right: 10px;">
                <input type="date" id="audit-end-date-input" class="form-control" hidden style="margin-right: 10px;"> -->
                <div id="FromToAudit" hidden >
                    <div class="d-flex justify-content-center">
                        <label for="" class="p-2">from</label>
                        <input type="date" id="audit-start-date-input" class="form-control"  style="margin-right: 10px;">
                        <label for="" class="p-2">to</label>
                        <input type="date" id="audit-end-date-input" class="form-control"  style="margin-right: 10px;">
                    </div>
                </div>

            </div>
        </div>

        <table class="customTable" id="AuditsTable">
            <thead>
                <tr>
                    <th scope="col">DailyIncome</th>
                    <th scope="col">ServiceRevenue</th>
                    <th scope="col">ProductSoldAmount</th>
                    <th scope="col">CommisionAmount</th>
                    <th scope="col">CreatedAt</th>
                </tr>
            </thead>
            <tbody id="Auditstbody">
                <?php
                include "../Components/connection.php";
                $sql = "SELECT * FROM `dailyaudit`";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                        <td>{$row['DailyIncome']}</td>
                        <td>{$row['ServiceRevenue']}</td>
                        <td>\${$row['ProductSoldAmount']}</td>
                        <td>\${$row['CommisionAmount']}</td>
                        <td>{$row['CreatedAt']}</td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById("audits_Date-criteria-select").addEventListener("change", (e) => {
    const selectedDate = e.target.value;
    const dateInput = document.getElementById("Audit-date-input");
    const selectByMonth = document.getElementById("Audit-month-select");
    const fromtoRange = document.getElementById("FromToAudit");
    // const startDateInput = document.getElementById("audit-start-date-input");
    // const endDateInput = document.getElementById("audit-end-date-input");

    switch (selectedDate) {
        case "ByDay":
            dateInput.hidden = false;
            selectByMonth.hidden = true;
            fromtoRange.hidden = true;

            break;
        case "ByMonth":
            dateInput.hidden = true;
            selectByMonth.hidden = false;
            fromtoRange.hidden = true;

            break;
        case "Range":
            dateInput.hidden = true;
            selectByMonth.hidden = true;
            fromtoRange.hidden = false;
            
            break;
        default:
            dateInput.hidden = true;
            selectByMonth.hidden = true;
            fromtoRange.hidden = true;

            break;
    }
});

document.getElementById('Audit-month-select').addEventListener("change", (e) => {
    const selectedMonth = e.target.value;
    updateAuditTableByMonth(selectedMonth);
});

document.getElementById('Audit-date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterAuditTable(searchDate, 'date');
});

document.getElementById('audit-start-date-input').addEventListener("input", (e) => {
    const startDate = e.target.value;
    const endDate = document.getElementById('audit-end-date-input').value;
    filterAuditTableByRange(startDate, endDate);
});

document.getElementById('audit-end-date-input').addEventListener("input", (e) => {
    const endDate = e.target.value;
    const startDate = document.getElementById('audit-start-date-input').value;
    filterAuditTableByRange(startDate, endDate);
});

function updateAuditTableByMonth(month) {
    let tbody = document.getElementById("Auditstbody");
    const option = { method: "GET" };
    fetch(`http://localhost/CarWashProject/Finance/GetAuditsMonth.php?Month=${month}`, option)
    .then(response => response.json())
    .then(audits => {
        tbody.innerHTML = '';
        if (audits) {
            audits.forEach(audit => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>$${audit.DailyIncome}</td>
                    <td>$${audit.ServiceRevenue}</td>
                    <td>$${audit.ProductSoldAmount}</td>
                    <td>$${audit.CommisionAmount}</td>
                    <td>${audit.CreatedAt}</td>
                `;
                tbody.appendChild(row);
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

function filterAuditTable(searchTerm, type) {
    const rows = document.querySelectorAll('#Auditstbody tr');
    rows.forEach(row => {
        const auditDate = row.cells[4].textContent;
        if (type === 'date') {
            if (auditDate.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

function filterAuditTableByRange(startDate, endDate) {
    const rows = document.querySelectorAll('#Auditstbody tr');
    rows.forEach(row => {
        const auditDate = row.cells[4].textContent;
        if (auditDate >= startDate && auditDate <= endDate) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
