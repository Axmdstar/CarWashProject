<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-center">
            <h1 class="card-title">Audits Report</h1>
            
            <div class="btn-group" style="margin: 14px 0 0 auto; height: 40px;" role="group" aria-label="Basic example">
                <input type="date" id="service-date-input" class="form-control" style="margin-right: 10px;">
                <select class="form-select" id="service-month-select">
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
                $sql = "SELECT * FROM `dailyaudit` ";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                        <td>$row[DailyIncome]</td>
                        <td>$row[ServiceRevenue]</td>
                        <td>$$row[ProductSoldAmount]</td>
                        <td>$row[CommisionAmount]</td>
                        <td>$row[CreatedAt]</td>
                        </tr>
                    ";
                }?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('service-month-select').addEventListener("change", (e) => {
    const selectedMonth = e.target.value;
    updateServiceTable(selectedMonth);
});


document.getElementById('service-date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterServiceTable(searchDate, 'date');
});

function updateServiceTable(month) {
    let tbody = document.getElementById("Auditstbody");
    const option = { method: "GET" };
    fetch(`http://localhost/CarWashProject/Finance/GetAuditsMonth.php?Month=${month}`, option)
    .then(response => response.json())
    .then(Audit => {
        tbody.innerHTML = '';
        services.forEach(function(Audit) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>$${Audit.DailyIncome}</td>
                <td>$${Audit.ServiceRevenue}</td>
                <td>$${Audit.ProductSoldAmount}</td>
                <td>$${Audit.CommisionAmount}</td>
                <td>${Audit.CreatedAt}</td>
            `;
            tbody.appendChild(row);
        });
    })
    .catch(error => console.error('Error:', error));
}

function filterServiceTable(searchTerm, type) {
    const rows = document.querySelectorAll('#Auditstbody tr');
    rows.forEach(row => {
        const serviceDate = row.cells[5].textContent;
         if (type === 'date') {
            if (serviceDate.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>


