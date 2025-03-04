

setTimeout(() => {
    const successMessage = document.querySelector('.bg-green-500');
    if (successMessage) {
        successMessage.style.transition = "opacity 0.5s";
        successMessage.style.opacity = "0";

        setTimeout(() => {
            successMessage.remove();
        }, 500);
    }
}, 3000);

let pending = document.querySelector('#pending');
let completed = document.querySelector('#completed');
let prevmonth = document.querySelector('#prevmonth')
let prevyear = document.querySelector('#prevyear')
let orderContainer = document.querySelector('#orderContainer');

//serachinput
let searchbar = document.querySelector('#searchbar');


// prevmonth.addEventListener('change',()=>console.log('hi'))

function updateOrders() {
    let statusFilters = [];
    let dateFilters = {};
    let inputFilters;

    if (pending.checked) {
        statusFilters.push('pending');
    }
    if (completed.checked) {
        statusFilters.push('completed');
    }
    if (prevmonth.checked) {
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        dateFilters.startDate = thirtyDaysAgo.toISOString().split('T')[0];
        dateFilters.endDate = new Date().toISOString().split('T')[0];
    }
    if (prevyear.checked) {
        dateFilters.startDate = '2024-01-01';
        dateFilters.endDate = '2024-12-31';
    }

    inputFilters = searchbar.value;

    filter(statusFilters, dateFilters, inputFilters);
}

pending.addEventListener('change', updateOrders);
completed.addEventListener('change', updateOrders);
prevmonth.addEventListener('change', updateOrders);
prevyear.addEventListener('change', updateOrders);


searchbar.addEventListener('input', updateOrders)




async function filter(statusFilters, dateFilters, inputFilters) {
    try {
        let url = '/search?';
        if (statusFilters.length > 0) {
            url += `status=${statusFilters.join(',')}&`;
        }
        if (dateFilters.startDate && dateFilters.endDate) {
            url += `startDate=${dateFilters.startDate}&endDate=${dateFilters.endDate}&`;
        }
        if (inputFilters.length > 1) {
            url += `term=${inputFilters}`
        }

        // Remove trailing '&' if present
        url = url.replace(/&$/, '');

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`http error status: ${response.status}`);
        }
        const data = await response.json();
        orderContainer.innerHTML = ''; // Clear existing orders
        console.log(data);

        if (data.length === 0) { // Check for empty results
            const noResultsDiv = document.createElement('div');
            noResultsDiv.classList.add('bg-gray-100', 'p-4', 'rounded-lg', 'shadow-md', 'text-center'); // Added text-center
            noResultsDiv.innerHTML = `<p>No products found matching your filters.</p>`; // Use <p> for better semantics
            orderContainer.appendChild(noResultsDiv);
        } else {
            // Your code to render the orders



            data.forEach(order => {
                // Create the order div
                const orderDiv = document.createElement('div');
                orderDiv.classList.add('bg-gray-100', 'p-4', 'rounded-lg', 'shadow-md');

                // Order Header
                const headerDiv = document.createElement('div');
                headerDiv.classList.add('flex', 'justify-between', 'items-center', 'border-b', 'pb-2', 'mb-4');
                headerDiv.innerHTML = `
                <h3 class="text-lg font-semibold text-gray-700">
                    Order #${order.id} - 
                    <span class="text-blue-500">${order.order_status.charAt(0).toUpperCase() + order.order_status.slice(1)}</span>
                </h3>
                 
                <span class="text-sm text-gray-500">Placed on: ${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
            `;

                orderDiv.appendChild(headerDiv);

                // Order Items
                const itemsDiv = document.createElement('div');
                itemsDiv.classList.add('grid', 'gap-4');

                order.order_items.forEach(item => {
                    if (item.product) {
                        const itemDiv = document.createElement('div');
                        itemDiv.classList.add('flex', 'items-center', 'gap-6', 'bg-white', 'p-4', 'rounded-md', 'shadow-sm');
                        itemDiv.innerHTML = `
                        <img src="/storage/${item.product.image}" alt="${item.product.name}" class="w-24 h-24 object-cover rounded-md border">
                        <div class="flex-1">
                            <h2 class="text-lg font-medium text-gray-800">${item.product.name}</h2>
                            <p class="text-sm text-gray-600">Quantity: <span class="font-semibold">${item.quantity}</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-700">$${item.price}</p>
                        </div>
                    `;
                        itemsDiv.appendChild(itemDiv);
                    } else {
                        itemsDiv.innerHTML += '<p class="text-red-500">Product not found</p>';
                    }
                });

                orderDiv.appendChild(itemsDiv);
                orderContainer.appendChild(orderDiv);
            });

        }


    } catch (error) {
        console.log(error);
    }
}

// updateOrders()
