<!-- Services -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <h1 class="card-title">Services Report</h1>
            
            <div class="btn-group" style="margin: 14px 0 0 auto; height: 40px;" role="group" aria-label="Basic example">
                <input type="text" id="search-service-input" class="form-control" placeholder="Search by car type" style="margin-right: 10px;">
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

        <table class="customTable" id="ServiceTable">
            <thead>
                <tr>
                    <th scope="col">CarType</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Customer Number</th>
                    <th scope="col">Createdby</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody id="Serviceouttbody">
                <?php
                include_once "../Components/connection.php";
                $sql = "SELECT `Cartype`, `category`, `Amount`, `CreatedAT`, `CustomerNumber`, usr.Username as Createdby FROM
                        `dailyservices` as ds INNER JOIN users as usr on ds.UsrId = usr.id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                        <td>$row[Cartype]</td>
                        <td>$row[category]</td>
                        <td>$$row[Amount]</td>
                        <td>$row[CustomerNumber]</td>
                        <td>$row[Createdby]</td>
                        <td>$row[CreatedAT]</td>
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

document.getElementById('search-service-input').addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    filterServiceTable(searchTerm, 'carType');
});

document.getElementById('service-date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterServiceTable(searchDate, 'date');
});

function updateServiceTable(month) {
    let tbody = document.getElementById("Serviceouttbody");
    const option = { method: "GET" };
    fetch(`http://localhost/CarWashProject/Finance/GetServiceMonth.php?Month=${month}`, option)
    .then(response => response.json())
    .then(services => {
        tbody.innerHTML = '';
        services.forEach(function(service) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${service.Cartype}</td>
                <td>${service.category}</td>
                <td>$${service.Amount}</td>
                <td>${service.CustomerNumber}</td>
                <td>${service.Createdby}</td>
                <td>${service.CreatedAT}</td>
            `;
            tbody.appendChild(row);
        });
    })
    .catch(error => console.error('Error:', error));
}

function filterServiceTable(searchTerm, type) {
    const rows = document.querySelectorAll('#Serviceouttbody tr');
    rows.forEach(row => {
        const carType = row.cells[0].textContent.toLowerCase();
        const serviceDate = row.cells[5].textContent;
        if (type === 'carType') {
            if (carType.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        } else if (type === 'date') {
            if (serviceDate.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>
