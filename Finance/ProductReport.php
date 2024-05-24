<!-- Products -->
<div class="card col">
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <h1 class="card-title">Products Report</h1>
            <div class="btn-group" style="margin: 14px 0 0 auto; height: 40px;" role="group" aria-label="Basic example">
                <input type="text" id="search-input" class="form-control" placeholder="Search by product name" style="margin-right: 10px;">
                <input type="date" id="date-input" class="form-control" style="margin-right: 10px;">
                <select class="form-select" id="month-select">
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
      
        <table class="customTable" id="ProductTable">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">CustomerNumber</th>
                    <th scope="col">Date</th>
                    <th scope="col">CreatedBy</th>
                </tr>
            </thead>
            <tbody id="Prodouttbody">
                <?php
                include "../Components/connection.php";
                $sql = "SELECT `ProductName`, `Quantity`, `Amount`, `CustomerNumber`, `Solddate`, usr.Username as Createdby FROM `soldproducts` as sp
                        INNER JOIN users as usr on sp.UsrId = usr.id ";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                        <td>$row[ProductName]</td>
                        <td>$row[Quantity]</td>
                        <td>$$row[Amount]</td>
                        <td>$row[CustomerNumber]</td>
                        <td>$row[Solddate]</td>
                        <td>$row[Createdby]</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('month-select').addEventListener("change", (e) => {
    const selectedMonth = e.target.value;
    updateTable(selectedMonth);
});

document.getElementById('search-input').addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    filterTable(searchTerm, 'product');
});

document.getElementById('date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterTable(searchDate, 'date');
});

function updateTable(month) {
    let tbody = document.getElementById("Prodouttbody");
    const option = { method: "GET" };
    fetch(`http://localhost/CarWashProject/Finance/GetProductMonth.php?Month=${month}`, option)
    .then(response => response.json())
    .then(products => {
        tbody.innerHTML = '';
        products.forEach(function(product) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.ProductName}</td>
                <td>${product.Quantity}</td>
                <td>$${product.Amount}</td>
                <td>${product.CustomerNumber}</td>
                <td>${product.Solddate}</td>
                <td>${product.Createdby}</td>
            `;
            tbody.appendChild(row);
        });
    })
    .catch(error => console.error('Error:', error));
}

function filterTable(searchTerm, type) {
    const rows = document.querySelectorAll('#Prodouttbody tr');
    rows.forEach(row => {
        const productName = row.cells[0].textContent.toLowerCase();
        const productDate = row.cells[4].textContent;
        if (type === 'product') {
            if (productName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        } else if (type === 'date') {
            if (productDate.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>
