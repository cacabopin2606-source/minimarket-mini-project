const searchInput = document.getElementById("searchProduct");
const productResults = document.getElementById("productResults");

let cart = [];
let selectedPaymentMethod = "Tunai";

searchInput.addEventListener("input", searchProduct);

/* ============================================
   SEARCH PRODUCT
============================================ */
function searchProduct() {
    const keyword = searchInput.value.toLowerCase().trim();

    if (!keyword) {
        productResults.style.display = "none";
        return;
    }

    const results = products.filter((product) => {
        return (
            product.name.toLowerCase().includes(keyword) ||
            (product.code ?? "").toLowerCase().includes(keyword) ||
            (product.barcode ?? "").toLowerCase().includes(keyword)
        );
    });

    if (results.length === 0) {
        productResults.innerHTML = `
            <div class="product-item">Barang tidak ditemukan</div>
        `;
    } else {
        productResults.innerHTML = results.map((product) => `
            <div class="product-item" onclick="addToCart(${product.id})">
                <div>
                    <div class="product-name">${product.name}</div>
                    <div class="product-code">
                        ${product.code ?? "-"} - ${product.barcode ?? "-"} | Stok: ${product.stock}
                    </div>
                </div>
                <div class="product-price">
                    ${formatRupiah(product.price)}
                </div>
            </div>
        `).join("");
    }

    productResults.style.display = "block";
}

/* ============================================
   FORMAT RUPIAH
============================================ */
function formatRupiah(value) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0
    }).format(value);
}

/* ============================================
   ADD TO CART
============================================ */
function addToCart(productId) {
    const product = products.find((p) => p.id === productId);
    if (!product) return;

    const existing = cart.find((item) => item.id === productId);

    if (existing) {
        if (existing.qty >= product.stock) {
            alert("Jumlah melebihi stok produk.");
            return;
        }
        existing.qty++;
    } else {
        cart.push({
            ...product,
            qty: 1
        });
    }

    searchInput.value = "";
    productResults.style.display = "none";
    renderCart();
}

/* ============================================
   RENDER CART
============================================ */
function renderCart() {
    const body = document.getElementById("cartBody");

    if (cart.length === 0) {
        body.innerHTML = `
            <tr>
                <td colspan="6" class="empty-cart">
                    Keranjang masih kosong.<br>
                    Silakan cari atau scan barang.
                </td>
            </tr>
        `;
        calculateTotal();
        return;
    }

    body.innerHTML = cart.map((item, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>
                <strong>${item.name}</strong>
                <div style="font-size:11px; color:#6c757d;">
                    ${item.code ?? "-"}
                </div>
            </td>
            <td>${formatRupiah(item.price)}</td>
            <td>
                <div class="qty-control">
                    <button onclick="changeQty(${item.id}, -1)">−</button>
                    <input type="number" value="${item.qty}" min="1" max="${item.stock}" onchange="updateQty(${item.id}, this.value)">
                    <button onclick="changeQty(${item.id}, 1)">+</button>
                </div>
            </td>
            <td class="text-right">
                <strong>${formatRupiah(item.price * item.qty)}</strong>
            </td>
            <td class="text-center">
                <button class="remove-btn" onclick="removeItem(${item.id})">×</button>
            </td>
        </tr>
    `).join("");

    calculateTotal();
}

/* ============================================
   QTY CONTROLLERS
============================================ */
function changeQty(id, amount) {
    const item = cart.find((item) => item.id === id);
    if (!item) return;

    const newQty = item.qty + amount;

    if (newQty <= 0) {
        removeItem(id);
        return;
    }

    if (newQty > item.stock) {
        alert("Jumlah melebihi stok produk.");
        return;
    }

    item.qty = newQty;
    renderCart();
}

function updateQty(id, qty) {
    const item = cart.find((item) => item.id === id);
    if (!item) return;

    qty = parseInt(qty);

    if (isNaN(qty) || qty < 1) {
        qty = 1;
    }

    if (qty > item.stock) {
        alert("Jumlah melebihi stok. Stok tersedia: " + item.stock);
        qty = item.stock;
    }

    item.qty = qty;
    renderCart();
}

function removeItem(id) {
    cart = cart.filter((item) => item.id !== id);
    renderCart();
}

/* ============================================
   CALCULATIONS
============================================ */
function calculateTotal() {
    let totalQty = 0;
    let subtotal = 0;

    cart.forEach((item) => {
        totalQty += item.qty;
        subtotal += item.price * item.qty;
    });

    const discountPercent = parseFloat(document.getElementById("discountPercent").value) || 0;
    const manualDiscount = parseFloat(document.getElementById("discountAmount").value) || 0;
    const tax = parseFloat(document.getElementById("tax").value) || 0;
    const otherFee = parseFloat(document.getElementById("otherFee").value) || 0;

    const percentDiscount = subtotal * (discountPercent / 100);
    const totalDiscount = percentDiscount + manualDiscount;

    const grandTotal = Math.max(0, subtotal - totalDiscount + tax + otherFee);

    document.getElementById("totalQty").innerText = totalQty;
    document.getElementById("itemCount").innerText = totalQty + " Item";
    document.getElementById("subtotal").innerText = formatRupiah(subtotal);
    document.getElementById("grandTotal").innerText = formatRupiah(grandTotal);

    calculateChange();
}

function getGrandTotal() {
    let subtotal = 0;

    cart.forEach((item) => {
        subtotal += item.price * item.qty;
    });

    const discountPercent = parseFloat(document.getElementById("discountPercent").value) || 0;
    const discountAmount = parseFloat(document.getElementById("discountAmount").value) || 0;
    const tax = parseFloat(document.getElementById("tax").value) || 0;
    const otherFee = parseFloat(document.getElementById("otherFee").value) || 0;

    const discount = (subtotal * discountPercent / 100) + discountAmount;

    return Math.max(0, subtotal - discount + tax + otherFee);
}

function calculateChange() {
    const grandTotal = getGrandTotal();
    const payment = parseFloat(document.getElementById("payment").value) || 0;
    const change = payment - grandTotal;

    const changeBox = document.getElementById("changeBox");
    const changeElement = document.getElementById("change");
    const changeLabel = document.querySelector(".change-label");

    if (change >= 0) {
        changeBox.classList.remove("short-payment");
        changeElement.innerText = formatRupiah(change);
        changeLabel.innerText = "KEMBALIAN";
    } else {
        changeBox.classList.add("short-payment");
        changeElement.innerText = formatRupiah(Math.abs(change));
        changeLabel.innerText = "UANG KURANG";
    }
}

/* ============================================
   PAYMENT METHOD
============================================ */
function selectPayment(button) {
    document.querySelectorAll(".payment-method button").forEach((btn) => {
        btn.classList.remove("active");
    });

    button.classList.add("active");
    selectedPaymentMethod = button.innerText;
}

/* ============================================
   TRANSACTION ACTIONS
============================================ */
function holdTransaction() {
    if (cart.length === 0) {
        alert("Tidak ada transaksi untuk ditahan.");
        return;
    }
    alert("Transaksi berhasil ditahan.");
}

function processPayment() {
    if (cart.length === 0) {
        alert("Keranjang masih kosong.");
        return;
    }

    const total = getGrandTotal();
    const payment = parseFloat(document.getElementById("payment").value) || 0;

    if (payment < total) {
        alert("Uang pembayaran masih kurang.");
        return;
    }

    const change = payment - total;

    alert(
        "Pembayaran berhasil!\n\n" +
        "Metode : " + selectedPaymentMethod + "\n" +
        "Total : " + formatRupiah(total) + "\n" +
        "Bayar : " + formatRupiah(payment) + "\n" +
        "Kembali : " + formatRupiah(change)
    );
}

function cancelTransaction() {
    if (!confirm("Batalkan transaksi ini?")) {
        return;
    }

    cart = [];

    document.getElementById("payment").value = "";
    document.getElementById("discountPercent").value = 0;
    document.getElementById("discountAmount").value = 0;
    document.getElementById("tax").value = 0;
    document.getElementById("otherFee").value = 0;

    renderCart();
}

/* ============================================
   EVENTS & INITIALIZATION
============================================ */
document.getElementById("currentDate").innerText = new Date().toLocaleString("id-ID");

document.getElementById("discountPercent").addEventListener("input", calculateTotal);
document.getElementById("discountAmount").addEventListener("input", calculateTotal);
document.getElementById("tax").addEventListener("input", calculateTotal);
document.getElementById("otherFee").addEventListener("input", calculateTotal);
document.getElementById("payment").addEventListener("input", calculateChange);

/* KEYBOARD SHORTCUTS */
document.addEventListener("keydown", function (event) {
    // F2 = pencarian
    if (event.key === "F2") {
        event.preventDefault();
        searchInput.focus();
    }

    // F4 = pembayaran
    if (event.key === "F4") {
        event.preventDefault();
        document.getElementById("payment").focus();
    }

    // ESC = batal
    if (event.key === "Escape") {
        cancelTransaction();
    }
});

/* INIT */
renderCart();