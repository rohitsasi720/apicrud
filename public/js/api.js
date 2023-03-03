const apiUrl = "/api/product";
const loginUrl = "/api/login";
const logoutUrl = "/api/logout";
const registerUrl = "/api/register";

async function getProducts() {
    const response = await fetch(apiUrl);
    const data = await response.json();
    return data;
}

async function getProductApi(productId) {
    const response = await fetch(`${apiUrl}/${productId}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    //console.log(response);
    const data = await response.json();
    return data;
}

async function createProductApi(product) {
    try {
        const formData = new FormData();
        formData.append("name", product.name);
        formData.append("category", product.category);
        formData.append("price", product.price);
        formData.append("image", product.image);

        

        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error("Failed to create product");
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
        throw new Error("Failed to create product");
    }
}

async function updateProductApi(product, productId) {
    try {
        const data = {
            name: product.name,
            category: product.category,
            price: product.price,
            image: document.getElementById("image").files[0],
        };

        const url = `${apiUrl}/${productId}`;
        const response = await fetch(url, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error("Failed to update product");
        }

        const responseData = await response.json();
        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error("Failed to update product");
    }
}



async function deleteProductApi(productId) {
    const response = await fetch(`${apiUrl}/${productId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    console.log(response);
    const data = await response.json();
    return data;
}

async function registerApi(credentials) {
    const response = await fetch(registerUrl, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
    });

    const data = await response.json();

    // if (response.ok && data.success) Check later if this works as this is not working but is better than status code
    if (response.ok) {
        localStorage.setItem("token", data.token);
        sessionStorage.setItem("alertMessage", "User created successfully.");
    } else {
        console.error(data.message);
        sessionStorage.setItem("alertMessage", data.message);
        throw new Error("Registration failed");
    }
}

async function loginApi(credentials) {
    const response = await fetch(loginUrl, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
    });
    const data = await response.json();

    if (response.ok) {
        localStorage.setItem("token", data.token);
        sessionStorage.setItem("alertMessage", "Logged in successfully.");
    } else {
        console.error(data.message);
        sessionStorage.setItem("alertMessage", data.message);
        throw new Error("Login failed");
    }
}

async function logoutApi() {
    const response = await fetch(logoutUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    const data = await response.json();
    localStorage.removeItem("token");
    if (!response.ok) {
        throw new Error("Logout failed");
    }
}
