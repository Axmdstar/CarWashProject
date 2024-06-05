<!-- Products -->
<div class="card col">
    <div class="card-body">
        <h1 class="card-title">Products Report</h1>
        <div class="d-flex justify-content-center">
            <div class="btn-group" style="margin: 14px auto 0 0; height: 40px;" role="group" aria-label="Basic example">
                <select class="form-select" id="products_Date-criteria-select" style="margin-right: 10px;">
                    <option disabled selected>Filter Date</option>
                    <option value="ByDay">By Day</option>
                    <option value="ByMonth">By Month</option>
                    <option value="Range">Custom Range</option>
                </select>
                <input type="date" id="product-date-input" class="form-control" hidden style="margin-right: 10px;">
                <select class="form-select" id="product-month-select" hidden style="margin-right: 10px;">
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
                <input type="date" id="product-start-date-input" class="form-control" hidden style="margin-right: 10px;">
                <input type="date" id="product-end-date-input" class="form-control" hidden style="margin-right: 10px;">
                <select class="form-select" id="products_search-criteria-select" style="margin-right: 10px;">
                    <option value="product">Product Name</option>
                    <option value="customerNumber">Customer Number</option>
                    <option value="createdBy">Created By</option>
                </select>
                <input type="text" id="search-product-input" class="form-control" placeholder="Search" style="margin-right: 10px;">
            </div>
        </div>
      
        <table class="customTable" id="ProductTable">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Customer Number</th>
                    <th scope="col">Date</th>
                    <th scope="col">Created By</th>
                </tr>
            </thead>
            <tbody id="Prodouttbody">
                <?php
                include "../Components/connection.php";
                $sql = "SELECT `ProductName`, `Quantity`, `Amount`, `CustomerNumber`, `Solddate`, IFNULL(usr.Username, 'DeletedUser') as Createdby FROM `soldproducts` as sp
                LEFT JOIN users as usr on sp.UsrId = usr.id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                        <td>{$row['ProductName']}</td>
                        <td>{$row['Quantity']}</td>
                        <td>\${$row['Amount']}</td>
                        <td>{$row['CustomerNumber']}</td>
                        <td>{$row['Solddate']}</td>
                        <td>{$row['Createdby']}</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById("products_Date-criteria-select").addEventListener("change", (e) => {
    const SelectedDate = e.target.value;
    const DateInput = document.getElementById("product-date-input");
    const SelectByMonth = document.getElementById("product-month-select");
    const StartDateInput = document.getElementById("product-start-date-input");
    const EndDateInput = document.getElementById("product-end-date-input");

    switch (SelectedDate) {
        case "ByDay":
            DateInput.hidden = false;
            SelectByMonth.hidden = true;
            StartDateInput.hidden = true;
            EndDateInput.hidden = true;
            break;
        case "ByMonth":
            DateInput.hidden = true;
            SelectByMonth.hidden = false;
            StartDateInput.hidden = true;
            EndDateInput.hidden = true;
            break;
        case "Range":
            DateInput.hidden = true;
            SelectByMonth.hidden = true;
            StartDateInput.hidden = false;
            EndDateInput.hidden = false;
            break;
        default:
            DateInput.hidden = true;
            SelectByMonth.hidden = true;
            StartDateInput.hidden = true;
            EndDateInput.hidden = true;
            break;
    }
});

document.getElementById('product-month-select').addEventListener("change", (e) => {
    const selectedMonth = e.target.value;
    updateProductTableByMonth(selectedMonth);
});

document.getElementById('search-product-input').addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const searchCriteria = document.getElementById('products_search-criteria-select').value;
    filterProductTable(searchTerm, searchCriteria);
});

document.getElementById('product-date-input').addEventListener("input", (e) => {
    const searchDate = e.target.value;
    filterProductTable(searchDate, 'date');
});

document.getElementById('product-start-date-input').addEventListener("input", (e) => {
    const startDate = e.target.value;
    const endDate = document.getElementById('product-end-date-input').value;
    filterProductTableByRange(startDate, endDate);
});

document.getElementById('product-end-date-input').addEventListener("input", (e) => {
    const endDate = e.target.value;
    const startDate = document.getElementById('product-start-date-input').value;
    filterProductTableByRange(startDate, endDate);
});

function updateProductTableByMonth(month) {
    let tbody = document.getElementById("Prodouttbody");
    const option = { method: "GET" };
    fetch(`http://localhost/CarWashProject/Finance/GetProductMonth.php?Month=${month}`, option)
    .then(response => response.json())
    .then(products => {
        tbody.innerHTML = '';
        products.forEach(product => {
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

function filterProductTable(searchTerm, type) {
    const rows = document.querySelectorAll('#Prodouttbody tr');
    rows.forEach(row => {
        const productName = row.cells[0].textContent.toLowerCase();
        const customerNumber = row.cells[3].textContent.toLowerCase();
        const createdBy = row.cells[5].textContent.toLowerCase();
        const productDate = row.cells[4].textContent;

        let isMatch = false;
        if (type === 'product') {
            isMatch = productName.includes(searchTerm);
        } else if (type === 'customerNumber') {
            isMatch = customerNumber.includes(searchTerm);
        } else if (type === 'createdBy') {
            isMatch = createdBy.includes(searchTerm);
        } else if (type === 'date') {
            isMatch = productDate.includes(searchTerm);
        }

        row.style.display = isMatch ? '' : 'none';
    });
}

function filterProductTableByRange(startDate, endDate) {
    const rows = document.querySelectorAll('#Prodouttbody tr');
    rows.forEach(row => {
        const productDate = row.cells[4].textContent;
        if (productDate >= startDate && productDate <= endDate) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
