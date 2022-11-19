import $ from "jquery";

const origin = window.location.origin,
    token = $('meta[name="csrf_token"]').attr('content');

const createUserUsingNickname = async () => {
    const nickname = $('input[name="set-nickname"]').val();
    try {
        $('button[name="add-nickname"]').text('Saving....').attr('disabled', true);
        console.log('Please Wait...');
        const response = await axios({
            method: 'POST',
            url: `${origin}/user/create-using-nickname`,
            data: {
                nickname: nickname,
                _token: token
            }
        });
        console.log(response.data);
        window.location.href = origin;
    } catch (error) {
        if (err.response) {
            console.log('error');
            console.log(error.response);
        } else if (err.request) {
            console.log(err.request)
        } else {
            // Anything else
            console.log('Sorry, something went wrong...');
        }
    } finally {
        $('button[name="add-nickname"]').text('Submit');
    }
}

const getAuthenticatedUser = async () => {
    try {
        const response = await axios.get(`${origin}/user/check-auth`);
        console.log(response.data);
        return response.data;
    } catch (error) {
        if (error.response && error.response.status == 401) {
            console.log('show nickname');
            const renderedSetNickname = await renderSetNickname();
            $('div#root').html(renderedSetNickname);
            return null;
        }
    }
}

const renderHome = async () => {
    window.location.href = `${origin}/`;

}


const renderHomeSkeleton = async() => { 
    try {
        const response = await axios.get(`${origin}/skeleton/home`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
 }

const renderFindMatch = async () => {
    window.location.href = `${origin}/find-match`;
    return true;
    try {
        const response = await axios.get(`${origin}/skeleton/find-match`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const renderLoader = async (text) => {
    try {
        const response = await axios.get(`${origin}/skeleton/loader/${text}`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const renderShop = async () => {
    try {
        const response = await axios.get(`${origin}/skeleton/shop`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const renderSetNickname = async () => {
    try {
        const response = await axios.get(`${origin}/skeleton/nickname`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const renderClassic = async () => {
    window.location.href = `${origin}/classic`;
}

const renderClassicSkeleton = async () => {
    try {
        const response = await axios.get(`${origin}/skeleton/classic`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const renderClassicSummary = async (level = 0, trophies = 0) => { 
    try {
        const response = await axios.get(`${origin}/skeleton/classic-summary/${level}/${trophies}`);
        return response.data;
    } catch (error) {
        console.log(error);
        return "Sorry, something went wrong...";
    }
 }

const renderMatchHistory = async () => {
    try {
        const response = await axios.get(`${origin}/skeleton/match-history`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

const logoutUser = async () => {
    try {
        $('#logout-text').text('Logging out...');
        const response = await axios({
            method: 'POST',
            url: `${origin}/ajax-logout`,
            data: {
                _token: token
            }
        });
        console.log(response);
        window.location.href = origin;
    } catch (error) {
        console.log('Sorry, something went wrong...');
        console.log(error.response)
    }
}

const sleep = (milliseconds) => {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
}

export {
    createUserUsingNickname,
    getAuthenticatedUser,
    logoutUser,
    renderClassic,
    renderClassicSkeleton,
    renderClassicSummary,
    renderFindMatch,
    renderHome,
    renderHomeSkeleton,
    renderLoader,
    renderMatchHistory,
    renderShop,
    sleep
}
