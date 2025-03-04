const categorySelect = document.getElementById('category');

let getCategory = async function () {
    try {
        const response = await fetch('/getcategory');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Clear the select box before adding options (optional)
        categorySelect.innerHTML = '<option value="">Select a category</option>';

        data.forEach(category => {
            let option = document.createElement('option');
            option.value = category.id; // Set category ID as the value
            option.textContent = category.name; // Set category name as the display text
            categorySelect.appendChild(option);
        });
        console.log('Categories loaded successfully');
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
};

// Call the function to populate the categories
getCategory();

category.addEventListener('change', function () {
    // get()
    console.log('hi')
})