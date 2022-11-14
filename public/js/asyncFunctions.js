const origin = window.location.origin,
    token = $('meta[name="csrf_token"]').attr('content');

async function createUserUsingNickName() {
    const nickname = $($nickNameInput).val();
    try {
        $($addNickNameBtn).text('Saving....');
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
        $($addNickNameBtn).text('Submit');
    }
}

async function getAuthenticatedUser() {
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

async function renderHome() {
    window.location.href=`${origin}/`;
    return false;
    try {
        const response = await axios.get(`${origin}/skeleton/home`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function renderFindMatch() {
    window.location.href=`${origin}/find-match`;
    return true;
    try {
        const response = await axios.get(`${origin}/skeleton/find-match`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function renderShop() {

    try {
        const response = await axios.get(`${origin}/skeleton/shop`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function renderSetNickname() {
    try {
        const response = await axios.get(`${origin}/skeleton/nickname`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function renderClassic() {
    try {
        const response = await axios.get(`${origin}/skeleton/classic`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function renderMatchHistory() {
    try {
        const response = await axios.get(`${origin}/skeleton/match-history`);
        return response.data;
    } catch (error) {
        return "Sorry, something went wrong...";
    }
}

async function logoutUser() {
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
