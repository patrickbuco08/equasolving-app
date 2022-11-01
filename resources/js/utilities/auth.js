const token = localStorage.getItem("bearer_token");
console.log('token', token);

export const User = async () => { 
    if(!token){
        await getUser();
    }
    const user = await getAuthUser();
    return user;
 }

export const getUser = async () => {
    try {
        const response = await axios({
            method: 'POST',
            url: `/api/auth`,
            data: {
                email: 'patrick.buco@gmail.com',
                password: 'password'
            }
        });
        localStorage.setItem("bearer_token", response.data.access_token);
        return response.data;
    } catch (err) {
        logError(err);
    }
}

const getAuthUser = async () => {
    try {
        const response = await axios({
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            method: 'GET',
            url: `/api/get-user`
        });
        return response.data;
    } catch (err) {
        logError(err);
    }
}

function logError(err) {
    if (err.response) {
        // The client was given an error response (5xx, 4xx)
        console.log('first error', err);
    } else if (err.request) {
        // The client never received a response, and the request was never left
        console.log('error request', err.request)
    } else {
        // Anything else
        console.log('Anything Else Error', err.message);
    }
}