
const apiUrl = "/api/products";
const loginUrl = "/api/login";
const logoutUrl = "/api/logout";


async function getProducts() {
    const response = await fetch(apiUrl);
    const data = await response.json();
    return data;
}


async function getProduct(productId) {
    const response = await fetch(`${apiUrl}/${productId}`);
    const data = await response.json();
    return data;
}


async function createProduct(product) {
    const response = await fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify(product),
    });
    const data = await response.json();
    return data;
}


async function updateProduct(productId, product) {
    const response = await fetch(`${apiUrl}/${productId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify(product),
    });
    const data = await response.json();
    return data;
}


async function deleteProduct(productId) {
    const response = await fetch(`${apiUrl}/${productId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    const data = await response.json();
    return data;
}


async function login(credentials) {
    const response = await fetch(loginUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
    });
    const data = await response.json();
    localStorage.setItem("token", data.token);
    return data;
}


async function logout() {
    const response = await fetch(logoutUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    const data = await response.json();
    localStorage.removeItem("token");
    return data;
}
