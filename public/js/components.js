const axios = require('axios');
const origin = window.location.origin;

export const getAuthenticatedUser = async () => { 
    try {
        const response = await axios.get(`${origin}/user/check-auth`);
        console.log(response.data);
    } catch (error) {
        if (error.response && error.response.status == 401) {
            console.log('show nickname');
            const renderedSetNickname = await renderSetNickname();
            $('div#root').html(renderedSetNickname);
            return null;
        }
    }
 }