// Doll Shop - JavaScript Functions

document.addEventListener("DOMContentLoaded", function () {
  // เพิ่มลงตะกร้าสินค้า
  const addCartButtons = document.querySelectorAll(".btn-add-cart");
  addCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      alert("ฟังก์ชันตะกร้าสินค้าอยู่ระหว่างการพัฒนา");
      // TODO: Implement add to cart functionality
    });
  });
});

// ฟังก์ชันสำหรับ Admin
function confirmDelete(message = "ต้องการลบรายการนี้หรือไม่?") {
  return confirm(message);
}

function formatCurrency(value) {
  return (
    "฿" +
    parseFloat(value).toLocaleString("th-TH", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    })
  );
}
