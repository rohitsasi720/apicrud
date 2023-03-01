
const apiUrl = "/api/product";
const loginUrl = "/api/login";
const logoutUrl = "/api/logout";
const registerUrl = "/api/register";


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
            "Accept": "application/json",
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
            "Accept": "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(credentials),
    });

    const data = await response.json();

    if (response.ok) {
        const token = data.token;
        if (!token) {
            console.error("Token not found");
            sessionStorage.setItem(
                "alertMessage",
                "Error: invalid response from server."
            );
            return;
        }

        
        try {
            const response = await fetch(loginUrl, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
                },
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                console.error(data.message);
                sessionStorage.setItem("alertMessage", "Error: invalid token.");
                return;
            }


            sessionStorage.setItem("alertMessage", "Logged in successfully.");
            window.location.href = "/products";
        } catch (error) {
            console.error(error);
            sessionStorage.setItem(
                "alertMessage",
                "Error: failed to verify token."
            );
        }
    } else {

        console.error(data.message);
        sessionStorage.setItem("alertMessage", data.message);
    }
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
