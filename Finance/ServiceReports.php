<!-- Services -->
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Services Report</h1>
        <div class="d-flex justify-content-center">
            
        <!-- filter start  -->
            <div class="btn-group" style="margin: 14px auto 0 0; height: 40px;" role="group" aria-label="Basic example">
                <!-- search     -->
                <select class="form-select" id="services_search-criteria-select" style="margin-right: 10px;">
                    <option disabled selected>Search By</option>
                    <option value="carType">Car Type</option>
                    <option value="category">Category</option>
                    <option value="customerNumber">Customer Number</option>
                    <option value="createdBy">Created By</option>
                </select>
                <input type="text" id="search-service-input" class="form-control" placeholder="Search" style="margin-right: 10px;">

                <!-- Dates  -->
                <select class="form-select" id="services_Date-criteria-select" style="margin-right: 10px;">
                    <option disabled selected>Filter DateBy</option>
                    <option value="ByDay">By Day</option>
                    <option value="ByMonth">By Month</option>
                    <option value="Range">Custom Range</option>
                </select>

                <input type="date" id="service-date-input" class="form-control" hidden style="margin-right: 10px;">

                <select class="form-select" id="service-month-select" hidden style="margin-right: 10px;">
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

                <div id="FromTo" hidden >
                    <div class="d-flex justify-content-center">
                        <label for="" class="p-2">from</label>
                        <input type="date" id="service-start-date-input" class="form-control"  style="margin-right: 10px;">
                        <label for="" class="p-2">to</label>
                        <input type="date" id="service-end-date-input" class="form-control"  style="margin-right: 10px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- filter end  -->
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
                        `dailyservices` as ds INNER JOIN users as usr on ds.UsrId = usr.id  ORDER BY `CreatedAT` DESC";

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
document.getElementById("services_Date-criteria-select").addEventListener("change", (e) => {
    const SelectedDate = e.target.value;
    const DateInput = document.getElementById("service-date-input");
    const SelectByMonth = document.getElementById("service-month-select");
    const fromtoRange = document.getElementById("FromTo");
    // const StartDateInput = document.getElementById("service-start-date-input");
    // const EndDateInput = document.getElementById("service-end-date-input");

    switch (SelectedDate) {
        case "ByDay":
            DateInput.hidden = false;
            SelectByMonth.hidden = true;
            
            fromtoRange.hidden = true;
            // StartDateInput.hidden = true;
            // EndDateInput.hidden = true;
            break;
        case "ByMonth":
            DateInput.hidden = true;
            SelectByMonth.hidden = false;

            fromtoRange.hidden = true;
            // StartDateInput.hidden = true;
            // EndDateInput.hidden = true;
            break;
        case "Range":
            DateInput.hidden = true;
            SelectByMonth.hidden = true;

            fromtoRange.hidden = false;
            // StartDateInput.hidden = false;
            // EndDateInput.hidden = false;
            break;
        default:
            DateInput.hidden = true;
            SelectByMonth.hidden = true;

            fromtoRange.hidden = true;
            // StartDateInput.hidden = true;
            // EndDateInput.hidden = true;
            break;
    }
});

document.getElementById('service-month-select').addEventListener("change", (e) => {
    const selectedMonth = e.target.value;
    updateServiceTableByMonth(selectedMonth);
});

document.getElementById('search-service-input').addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const searchCriteria = document.getElementById('services_search-criteria-select').value;
    filterServiceTable(searchTerm, searchCriteria);
});

document.getElementById('service-date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterServiceTable(searchDate, 'date');
});

document.getElementById('service-start-date-input').addEventListener("input", (e) => {
    const startDate = e.target.value;
    const endDate = document.getElementById('service-end-date-input').value;
    filterServiceTableByRange(startDate, endDate);
});

document.getElementById('service-end-date-input').addEventListener("input", (e) => {
    const endDate = e.target.value;
    const startDate = document.getElementById('service-start-date-input').value;
    filterServiceTableByRange(startDate, endDate);
});

function updateServiceTableByMonth(month) {
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
        const category = row.cells[1].textContent.toLowerCase();
        const customerNumber = row.cells[3].textContent.toLowerCase();
        const createdBy = row.cells[4].textContent.toLowerCase();
        const serviceDate = row.cells[5].textContent;

        if (type === 'carType' && carType.includes(searchTerm)) {
            row.style.display = '';
        } else if (type === 'category' && category.includes(searchTerm)) {
            row.style.display = '';
        } else if (type === 'customerNumber' && customerNumber.includes(searchTerm)) {
            row.style.display = '';
        } else if (type === 'createdBy' && createdBy.includes(searchTerm)) {
            row.style.display = '';
        } else if (type === 'date' && serviceDate.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterServiceTableByRange(startDate, endDate) {
    const rows = document.querySelectorAll('#Serviceouttbody tr');
    rows.forEach(row => {
        const serviceDate = row.cells[5].textContent;
        if (serviceDate >= startDate && serviceDate <= endDate) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
