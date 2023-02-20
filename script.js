const page = {
    login: `
        <h1>Phidias</h1>
        <div id='form'>
            <input type='text' id='username'>
            <input type='text' id='password'>
            <button onClick="Api.login()">Connexion</button>
        </div>
    `,
    

};

let state = {
    loading: false,
    user: null,
    page: "login"
};

const generateBody = () => {
    document.querySelector(".root").innerHTML=page[stateProxy.page];
};

const stateProxy = new Proxy(state, {
    set: function (target, key, value) {
        console.log(`${key} set to ${value}`);
        target[key] = value;
        generateBody();
        return true;
    }
});

const Api = {
    login: () => {
        stateProxy.loading = true;
        fetch("/api", {
            method: "POST",
            body: {
                action: 'login',
                username: document.querySelector("#username").value,
                password: document.querySelector("#password").value
            }
        }).then(() => {
            stateProxy.loading = false;
        });
    }
};

generateBody();