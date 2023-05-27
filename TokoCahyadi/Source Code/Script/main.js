$(document).ready(function () {
  console.log("ready!");
  $(".fade-up").each(function () {
    $(this).addClass("runFadeUp");
  });
});

const year = new Date().getFullYear();

$("#year").html(year);

$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (!(scroll > 0)) {
    $("#index-header").css("padding", "30px 100px");
    $("#index-header").css("background-color", "transparent");
    $("#index-logo").css("transform", "scale(1.2)");
    $("#index-logo").css("color", "var(--primaryFont)");
    $("#index-logo span").css("color", "#682633");
    $("#nav-index ul li a").css("color", "var(--secondaryColor)");
  } else {
    $("#index-logo").css("transform", "scale(1)");
    $("#index-header").css("background-color", "#682633");
    $("#index-header").css("padding", "20px 70px");
    $("#index-logo, #index-logo span").css("color", "#fff");
    $("#nav-index ul li a").css("color", "#fff");
  }
});

$(".pp-wrapper").click(function () {
  $(".option").toggleClass("active");
  $(".pp-wrapper").toggleClass("scale");
});

var currentValue = 0;
$(".increment-button").click(function () {
  var input = $(this).prev();
  currentValue = parseInt(input.val());
  var max = parseInt(
    $(this).closest(".cart-card").find(".product-stock").text()
  ); // ambil nilai maksimum dari .product-stock
  if (currentValue < max) {
    input.val(currentValue + 1);
    calculateTotal($(this).closest(".cart-card"));
  }
});

$(".decrement-button").click(function () {
  var input = $(this).next();
  currentValue = parseInt(input.val());
  if (currentValue > 1) {
    input.val(currentValue - 1);
    calculateTotal($(this).closest(".cart-card"));
  }
});

function restrictInput(input) {
  input.on("change", function () {
    var value = parseInt($(this).val());
    if (value < 1) {
      $(this).val(1);
    }
  });

  input.on("input", function () {
    var value = parseInt($(this).val());
    var max = parseInt($(this).attr("max"));
    if (value < 1) {
      $(this).val(1);
    } else if (value > max) {
      $(this).val(max);
    }
    calculateTotal($(this).closest(".cart-card"));
  });
}

restrictInput($(".quantity"));

// Calculate total per product and update the display
function calculateTotal(product) {
  var price = parseInt(
    product
      .find(".price span")
      .text()
      .replace(/[^,\d]/g, "")
  );
  var quantity = parseInt(product.find(".quantity").val());
  var total = price * quantity;
  product.find(".total").text(formatRupiah(total.toString(), ""));
  calculateGrandTotal();
}

// Calculate grand total and update the display
function calculateGrandTotal() {
  var grandTotal = 0;
  $(".cart-card").each(function () {
    var total = parseInt(
      $(this)
        .find(".total")
        .text()
        .replace(/[^,\d]/g, "")
    );
    grandTotal += total;
  });
  $("#lastTotal, #lastTotalCheckOut").text(
    formatRupiah(grandTotal.toString(), "")
  );
}

function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
}

$("#submit").click(function () {
  var totalAmount = parseInt($("#lastTotal").text().replace(/\D/g, ""));
  var money = parseInt($('[name="money"]').val().replace(/\D/g, ""));
  if (money === totalAmount) {
    $("#checkout-form").submit();
  } else if (money < totalAmount) {
    alert(
      "The amount of money you entered is less than the total amount. Please enter a valid amount"
    );
    $('[name="money"]').val("");
  } else {
    alert(
      "The amount of money you entered is more than the total amount. Please enter a valid amount"
    );
    $('[name="money"]').val("");
  }
});

function disableScroll() {
  $("body").css({
    overflow: "hidden",
  });
}

function enableScroll() {
  $("body").css({
    overflow: "",
  });
}

$("#checkout-btn").click(() => {
  $(".checkout-modal").css("top", "0");
  $(".cart-card").each(function () {
    // mencari input quantity untuk produk ini
    var $product = $(this);
    var idProduct = $product.attr("id");
    var $quantityInput = $product.find("input.quantity");
    // memindahkan nilai quantity ke input hidden dengan id "quantity"
    var quantityValue = $quantityInput.val();
    $("input[name='quantity[" + idProduct + "]']").val(quantityValue);
    console.log(quantityValue);
    console.log($("input[name='quantity[" + idProduct + "]']").val());
    console.log(idProduct);
  });
  disableScroll();
});

$("#cancel-modal").click(() => {
  $(".checkout-modal").css("top", "9000px");
  $(
    '.form-wrapper input:not([name="firstname"]):not([name="lastname"]):not([name="email"])'
  ).val("");
  enableScroll();
});

$(".heart-icon").click(function () {
  $(this).toggleClass("red pulsing");
});

$("#money").on("input", function () {
  var harga = $(this).val().replace(/\./g, "");
  $(this).val(function () {
    return harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});

$("#profile_picture").change(function () {
  $("#edit_pp").text($(this).val());
});

$("#edit_pp").click(function () {
  $("#profile_picture").click();
});

$("#profile_picture").change(function () {
  readURL(this);
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#preview-gambar").attr("src", e.target.result).show();
    };
    reader.readAsDataURL(input.files[0]);
  }
}
