(() => {
  const root = document.querySelector(".product-shell");
  if (!root) return;

  const currency = (value) => "Rs " + new Intl.NumberFormat("en-PK").format(value);
  const shipping = Number(root.dataset.shipping || 300);
  const bundleInput = document.querySelector("#bundle");
  const quantityInput = document.querySelector("#quantity");
  const quantityValue = document.querySelector("#quantity-value");
  const packageName = document.querySelector("#package-name");
  const packageCopy = document.querySelector("#package-copy");
  const unitLabel = document.querySelector("#unit-label");
  const summaryName = document.querySelector("#summary-name");
  const summarySubtotal = document.querySelector("#summary-subtotal");
  const summaryTotal = document.querySelector("#summary-total");
  const buttons = [...document.querySelectorAll("[data-package]")];

  let selected = buttons.find((button) => button.classList.contains("active")) || buttons[0];
  let quantity = 1;

  function render() {
    const price = Number(selected.dataset.price);
    const name = selected.dataset.name;
    const units = Number(selected.dataset.units);
    const subtotal = price * quantity;
    buttons.forEach((button) => button.classList.toggle("active", button === selected));
    bundleInput.value = selected.dataset.package;
    quantityInput.value = String(quantity);
    quantityValue.textContent = String(quantity);
    packageName.textContent = name;
    packageCopy.textContent = selected.dataset.copy;
    unitLabel.textContent = units + " × 100 ml";
    summaryName.textContent = name + " × " + quantity;
    summarySubtotal.textContent = currency(subtotal);
    summaryTotal.textContent = currency(subtotal + shipping);
  }

  buttons.forEach((button) => button.addEventListener("click", () => {
    selected = button;
    render();
  }));
  document.querySelector("#quantity-minus").addEventListener("click", () => {
    quantity = Math.max(1, quantity - 1);
    render();
  });
  document.querySelector("#quantity-plus").addEventListener("click", () => {
    quantity = Math.min(10, quantity + 1);
    render();
  });
  render();
})();
