document.addEventListener('DOMContentLoaded', () => {
    const colorInputs = document.querySelectorAll('input[name="color_id"]');
    const sizeContainer = document.getElementById('size-container');
    const stockQuantity = document.getElementById('stock_quantity');
    const addToCartBtn = document.getElementById('add-to-cart');
    const variantIdInput = document.getElementById('variant_id');
    function renderSizes(colorId) {
        const matchedVariants = variants.filter(v => v.color_id == colorId);
        const uniqueSizes = [...new Map(matchedVariants.map(v => [v.size_id, v])).values()];
        sizeContainer.innerHTML = '<h4>SIZE</h4>';
        uniqueSizes.forEach((variant, index) => {
            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'size_id';
            input.value = variant.size_id;
            input.id = `size_${variant.size_id}`;
            if (index === 0) input.checked = true;
            const label = document.createElement('label');
            label.htmlFor = `size_${variant.size_id}`;
            label.textContent = variant.product_size.name;
            sizeContainer.appendChild(input);
            sizeContainer.appendChild(label);
        });
        updateStock();
    }
    function updateStock() {
        const colorId = document.querySelector('input[name="color_id"]:checked')?.value;
        const sizeId = document.querySelector('input[name="size_id"]:checked')?.value;
        if (colorId && sizeId) {
            const variant = variants.find(v => v.color_id == colorId && v.size_id == sizeId);
            if (variant) {

                stockQuantity.textContent = variant.stock_quantity > 0 ? `在庫あり（残り ${variant.stock_quantity} 点）` : 'SOLD OUT';
                stockQuantity.style.display = 'block';

                addToCartBtn.disabled = variant.stock_quantity <= 0;

                if (variantIdInput) {
                    variantIdInput.value = variant.id;
                }

                const quantitySelect = document.getElementById('quantity');
                if (quantitySelect) {
                    quantitySelect.innerHTML = '';
                    for (let i = 1; i <= Math.min(variant.stock_quantity, 10); i++) {
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = i;
                        quantitySelect.appendChild(option);
                    }
                }

                const productImageDisplay = document.getElementById('product-image-display');
                if (productImageDisplay && variant.product_images?.length > 0) {
                    productImageDisplay.src = `/storage/${variant.product_images[0].image_path}`;
                }
            }
        }
    }
    colorInputs.forEach(el => el.addEventListener('change', e => {
        renderSizes(e.target.value);
    }));
    sizeContainer.addEventListener('change', e => {
        if (e.target.name === 'size_id') {
            updateStock();
        }
    });

    const defaultColorId = document.querySelector('input[name="color_id"]:checked')?.value;
    if (defaultColorId) {
        renderSizes(defaultColorId);
    }
});


