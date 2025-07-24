<script>

    // Utiliza o window porque esta pegando um valor vindo da pagina edit, um valor global
    let serviceIndex = window.serviceIndex ?? 0;
    let productIndex = window.productIndex ?? 0;

    let totalServicePrice = 0;
    let totalProductPrice = 0;

    // Constroi o html da linha e adiciona
    function buildRowService(name, quantity, unitPrice, totalPrice)
    {
        console.log(quantity)
        let row = `
<tr class="bg-white border-b">
    <td>
        <input type="text" name="services[${serviceIndex}][name]" value="${name}"
            class="service-name-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="services[${serviceIndex}][quantity]" value="${quantity}"
            class="service-quantity-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="services[${serviceIndex}][unit_price]" value="${unitPrice}"
            class="service-unit-price-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="services[${serviceIndex}][total_price]" value="${totalPrice}"
            class="service-total-price-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td class="flex">
        <button type="button" class="btn-remove-row ml-2 text-red-500">Excluir</button>
        <button type="button" class="btn-edit-service-row ml-2 mr-2 text-blue-500">Alterar</button>
    </td>
</tr>
        `;

        $('#services-table tbody').append(row);
        serviceIndex++;
    }

    // Obtem os valores a serem adicionados dinamicamente e chama funcao que constroi o html
    function addServiceRowTable()
    {
        const inputServiceName = $('#new-service-name');
        const inputServiceQuantity = $('#new-service-qty');
        const inputUnitPrice = $('#new-service-price');
        const inputServiceTotalPrice = $('#new-service-total-price');

        const serviceName = inputServiceName.val() || '';
        const serviceQuantity =  Number(inputServiceQuantity.val()) || '';
        const serviceUnitPrice = Number(inputUnitPrice.val()) || '';
        const serviceTotalPrice = Number(inputServiceTotalPrice.val()) || '';

        if (serviceName === '' || serviceQuantity === '' || serviceUnitPrice === '' || serviceTotalPrice === '') {

            alert('Preencha corretamente para adicionar!');

        } else {

            buildRowService(
                serviceName,
                serviceQuantity.toFixed(2),
                serviceUnitPrice.toFixed(2),
                serviceTotalPrice.toFixed(2),
            );

        }

        inputServiceName.val('');
        inputServiceQuantity.val('');
        inputUnitPrice.val('');
        inputServiceTotalPrice.val('');

    }

    // Constroi o html e aplica na tabela de produtos
    function buildRowProduct(name, qty, unitPrice, totalPrice)
    {
        let row = `
<tr class="bg-white border-b">
    <td>
        <input type="text" name="products[${productIndex}][description]" value="${name}"
            class="description-product-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="products[${productIndex}][quantity]" value="${qty}"
            class="quantity-product-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="products[${productIndex}][unit_price]" value="${unitPrice}"
            class="unit-price-product-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td>
        <input type="number" name="products[${productIndex}][total_price]" value="${totalPrice}"
            class="product-total-price-row w-full border-gray-300 rounded-md shadow-sm px-2 py-1" readonly
        >
    </td>
    <td class="flex">
        <button type="button" class="btn-remove-row ml-2 text-red-500">Excluir</button>
        <button type="button" class="btn-edit-product-row ml-2 mr-2 text-blue-500">Alterar</button>
    </td>
</tr>
        `;

        $('#products-table tbody').append(row);
        productIndex++;

    }

    // Remove a linha selecionada
    function removeRowTable(row)
    {
        $(row).closest('tr').remove();
    }

    // Coloca o foco para o campo de adicionar serviço
    function focusField(field)
    {
        $(field).focus();
    }

    // Obtem os valores do produto e chama funcao que cria a linha dinamica
    function addProductRowTable()
    {
        const productNameInput = $('#new-product-name');
        const productQtyInput = $('#new-product-qty');
        const productPriceInput = $('#new-product-price');
        const productTotalPriceInput = $('#new-product-total-price');

        const productName = productNameInput.val() || '';
        const productQty = Number(productQtyInput.val()) || 0;
        const productPrice = Number(productPriceInput.val()) || 0;
        const productTotalPrice = Number(productTotalPriceInput.val()) || 0;

        if (productName === '' || productQty === 0 || productPrice === 0) {
            alert('Preencha os campos do produto corretamente!');
        } else {
            buildRowProduct(
                productName,
                productQty.toFixed(2),
                productPrice.toFixed(2),
                productTotalPrice.toFixed(2)
            );
        }

        productNameInput.val('');
        productQtyInput.val('');
        productPriceInput.val('');
        productTotalPriceInput.val('');
    }

    // Soma o total de uma coluna pela classe passada contida em cada <td>
    function calculateTotalColumnByClass(classColumn)
    {
        let total = 0;

        $(classColumn).each(function () {
            total += Number($(this).val() || 0);
        });

        return total;
    }

    // Soma servicos e produtos
    function sumProductAndServicesTotals()
    {
        totalServicePrice = calculateTotalColumnByClass('.service-total-price-row');
        totalProductPrice = calculateTotalColumnByClass('.product-total-price-row');

        $('#total-services').val(totalServicePrice.toFixed(2)).trigger('input');
        $('#total-products').val(totalProductPrice.toFixed(2)).trigger('input');
    }

    $(document).ready(function () {

        // Adiciona servico
        $('#btn-add-service').on('click', function () {
            addServiceRowTable();
            focusField('#new-service-name');
        });

        // Adiciona produto
        $(document).on('click', '#btn-add-product', function () {
            addProductRowTable();
            focusField('#new-product-name');
        });

        // Remove linha de ambas as tabelas
        $(document).on('click', '.btn-remove-row', function () {
            removeRowTable($(this));
        });

        // Formata o valor total do PRODUTO a ser adicionado com duas casas decimais
        $(document).on('input', '#new-product-price, #new-product-qty', function () {

            const qty = Number($('#new-product-qty').val()) || 0;
            const price = Number($('#new-product-price').val()) || 0;
            const totalPrice = qty * price;

            $('#new-product-total-price').val(totalPrice.toFixed(2));

        });

        // Formata o valor total do SERVIÇO a ser adicionado com duas casas decimais
        $(document).on('input', '#new-service-qty, #new-service-price', function () {

            const qty = Number($('#new-service-qty').val()) || 0;
            const price = Number($('#new-service-price').val()) || 0;
            const totalPrice = qty * price;

            $('#new-service-total-price').val(totalPrice.toFixed(2));

        });

        // Atualiza total de produtos e serviços
        $(document).on('click', '#btn-add-service, #btn-add-product, .btn-remove-row', function () {

            sumProductAndServicesTotals();

        });

        // Calcula o total da OS (produtos + servicos - descontos)
        $(document).on('input', '#total-services, #total-products, #discount', function () {
            services = Number($('#total-services').val() || 0);
            products = Number($('#total-products').val() || 0);
            discount = Number($('#discount').val() || 0);

            totalSO = (products + services) - discount;

            $('#total-os').val(totalSO.toFixed(2));

        });

        // Coloca linha da tabela serviços em modo edição
        $(document).on('click', '.btn-edit-service-row', function () {

            let tr = $(this).closest('tr');

            let nameInput = tr.find('.service-name-row');
            let quantityInput = tr.find('.service-quantity-row');
            let unitPriceInput = tr.find('.service-unit-price-row');

            nameInput.removeAttr('readonly');
            quantityInput.removeAttr('readonly');
            unitPriceInput.removeAttr('readonly');

            let button = tr.find('.btn-edit-service-row');
            button.text('Salvar');
            button.removeClass('text-blue-500');
            button.addClass('text-green-500 btn-save-service-row');

        });

        // SALVA linha da tabela serviços do modo de edição
        $(document).on('click', '.btn-save-service-row', function () {

            let tr = $(this).closest('tr');

            let nameInput = tr.find('.service-name-row');
            let quantityInput = tr.find('.service-quantity-row');
            let unitPriceInput = tr.find('.service-unit-price-row');

            if (nameInput.val() === '' || quantityInput.val() === '' || unitPriceInput.val() === '') {

                alert('Não deixe nenhum campo em branco!');

            } else {

                nameInput.attr('readonly', true);
                quantityInput.attr('readonly', true);
                unitPriceInput.attr('readonly', true);

                let button = tr.find('.btn-edit-service-row');
                button.text('Editar');
                button.removeClass('text-green-500 btn-save-service-row');
                button.addClass('text-blue-500');

            }
        });

        // Coloca linha da tabela produtos em modo edição
        $(document).on('click', '.btn-edit-product-row', function () {

            let tr = $(this).closest('tr');

            let descriptionInput = tr.find('.description-product-row');
            let quantityInput = tr.find('.quantity-product-row');
            let unitPriceInput = tr.find('.unit-price-product-row');

            descriptionInput.removeAttr('readonly');
            quantityInput.removeAttr('readonly');
            unitPriceInput.removeAttr('readonly');


            let button = tr.find('.btn-edit-product-row');
            button.text('Salvar');
            button.removeClass('text-blue-500');
            button.addClass('text-green-500 btn-save-product-row');
        });

        // SALVA linha da tabela produtos do modo de edição
        $(document).on('click', '.btn-save-product-row', function () {

            let tr = $(this).closest('tr');

            let descriptionInput = tr.find('.description-product-row');
            let quantityInput = tr.find('.quantity-product-row');
            let unitPriceInput = tr.find('.unit-price-product-row');;

            if (descriptionInput.val() === '' || quantityInput.val() === '' || unitPriceInput === '') {

                alert('Não deixe nenhum campo em branco!');

            } else {

                descriptionInput.attr('readonly', true);
                quantityInput.attr('readonly', true);
                unitPriceInput.attr('readonly', true);

                let button = tr.find('.btn-edit-product-row');
                button.text('Editar');
                button.removeClass('text-green-500 btn-save-product-row');
                button.addClass('text-blue-500');

            }
        });

        // Atualiza preço da linha atual da tabela de produtos caso usuário edite
        $(document).on('input', '.quantity-product-row, .unit-price-product-row', function () {

            let tr = $(this).closest('tr');

            let quantity = Number(tr.find('.quantity-product-row').val() || 0);
            let unitPrice = Number(tr.find('.unit-price-product-row').val() || 0);
            let totalPriceRow = tr.find('.product-total-price-row');

            let total = unitPrice * quantity;

            totalPriceRow.val(total.toFixed(2))

            sumProductAndServicesTotals();
        })

        // Atualiza preço da linha atual da tabela de serviços caso usuário edite
        $(document).on('input', '.service-quantity-row, .service-unit-price-row', function () {

            let tr = $(this).closest('tr');

            let quantity = Number(tr.find('.service-quantity-row').val() || 0);
            let unitPrice = Number(tr.find('.service-unit-price-row').val() || 0);
            let totalPriceRow = tr.find('.service-total-price-row');

            let total = unitPrice * quantity;
            totalPriceRow.val(total.toFixed(2))

            sumProductAndServicesTotals();
        })

        // Formata linhas numericas das tabelas para duas casas decimais ao perder o foco
        $(document).on('change',
            '.service-price-row, .quantity-product-row, .unit-price-product-row,' +
            '.service-quantity-row, .service-unit-price-row',
            function () {
                let value = Number($(this).val() || 0);
                $(this).val(value.toFixed(2));
            }
        );


    });
</script>
