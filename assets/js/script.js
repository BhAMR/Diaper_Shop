function toggleMenu() {
    var menu = document.getElementById("navMenu");
    menu.classList.toggle("show");
}

window.onload = function () {
    setTimeout(function () {
        var err = document.getElementsByClassName('error-msg')[0];
        if (err && err.innerHTML !== "") {
            err.style.display = "none";
        }
    }, 3000);
}

function back() {
    window.location.href = "dashboard.php";
}

function goBack() {
    window.location.href = "index.php";
}

//zoom-in image
function openImageModal(imageSrc){
    document.getElementById("imageModalImg").src = imageSrc;

    const modal = new bootstrap.Modal(document.getElementById("imageModal"));
    modal.show();
}

// Increase/decrease cart quantity without refreshing the page.
function updateQty(id, action) {
    let qtyInput = document.querySelector(".qty-" + id);
    let currentQty = parseInt(qtyInput.value);
    let badge = document.getElementById('cartCountBadge');

    if (action === 'dec' && currentQty == 1) {
        return;
    }

    fetch('updateCartAjax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&action=${action}`
    })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            if (data.qty <= 0) {
                location.reload();
                return;
            }

            qtyInput.value = data.qty;
            document.querySelector('.row-total-' + id).innerText = data.rowTotal;
            
            // Update subtotal and total
            document.getElementById('cartSubtotal').innerText = data.cartTotal;
            document.getElementById('payAmount').innerText = data.cartTotal;
            document.getElementById('payAmountDuplicate').innerText = data.cartTotal;

            let minusButton = qtyInput.closest('.qty-box').querySelector('.btn-outline-danger');
            minusButton.disabled = (data.qty <= 1);

            if (badge) {
                badge.innerText = data.productCount;
                badge.style.display = data.productCount > 0 ? 'inline-block' : 'none';
            }
        })
        .catch(err => console.error('Error updating qty:', err));
}

function removeItem(id) {
    if (!confirm("Really want to remove item?")) return;

    fetch('updateCartAjax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&action=remove`
    })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Remove row
            document.getElementById("cart-row-" + id).remove();

            // Update subtotal and total
            document.getElementById('cartSubtotal').innerText = data.cartTotal;
            document.getElementById('payAmount').innerText = data.cartTotal;
            document.getElementById('payAmountDuplicate').innerText = data.cartTotal;

            let badge = document.getElementById('cartCountBadge');
            if (badge) {
                badge.innerText = data.productCount;
                badge.style.display = data.productCount > 0 ? 'inline-block' : 'none';
            }

            // If cart is empty, reload
            if (data.productCount <= 0) {
                location.reload();
            }
        })
        .catch(err => console.error('Error removing item:', err));
}

/* Change quantity in placeOrder */
function changeQty(step) {
    let price = parseInt(document.getElementById("price").value);
    let qtyInput = document.getElementById("qty");
    let qtyHidden = document.getElementById("qtyHidden");
    let minusBtn = document.getElementById("minusBtn");
    let payAmount = document.getElementById("payAmount");
    let total = document.getElementById("Total");
    let maxStock = parseInt(document.getElementById("maxStock").value);

    let qty = parseInt(qtyInput.value);
    qty += step;
    if (qty < 1) qty = 1;

    if(qty > maxStock){
        alert(`only ${maxStock} item(s) available in stock..`);
        qty = maxStock;
    }

    qtyInput.value = qty;
    qtyHidden.value = qty;

    total.innerText = price * qty;
    payAmount.innerText = price * qty;

    minusBtn.disabled = (qty === 1);
}

function fetchCity() {
    const pin = document.querySelector('input[name="pincode"]').value;

    if (pin.length === 6 && !isNaN(pin)) {
        fetch(`https://api.postalpincode.in/pincode/${pin}`)
            .then(res => res.json())
            .then(data => {
                if (
                    data[0].Status === "Success" &&
                    data[0].PostOffice &&
                    data[0].PostOffice.length > 0
                ) {
                    const postOffice = data[0].PostOffice[0];
                    const area = postOffice.Name;
                    const city = postOffice.Block || postOffice.Taluk;
                    const district = postOffice.District;

                    document.getElementById("city").value = area + ", " + city + ", " + district;
                } else {
                    document.getElementById("city").value = "Invalid Pincode";
                }
            })
            .catch(() => {
                document.getElementById("city").value = "Error fetching data";
            });
    }
}