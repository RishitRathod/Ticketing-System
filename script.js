// Define base URL
const baseURL = 'https://your-api-url.com';

// Create
async function createData(url = '', data = {}) {
    try {
        const response = await fetch(baseURL + url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}

// Read
async function getData(url = '') {
    try {
        const response = await fetch(baseURL + url);
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}

// Update
async function updateData(url = '', data = {}) {
    try {
        const response = await fetch(baseURL + url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}

// Delete
async function deleteData(url = '') {
    try {
        const response = await fetch(baseURL + url, {
            method: 'DELETE'
        });
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}