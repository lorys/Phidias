import React, { useState, useEffect } from "react";
import { Button, Input } from "@mui/material";

const LoginPage = () => {
    const [mail, setMail] = useState("");
    const [pass, setPass] = useState("");
    const [loading, setLoading] = useState(false);
    const login = () => {
        fetch("/api", {
            method: "POST"
            body: 
        })
    };
    return <div style={{ display: "block", width: "50vw", height: "50vh", margin: "auto"}}>
        <Input style={{ display: 'block' }} placeholder="mail" type={"email"} required value={mail}
          onChange={(event) =>
            setMail(event.target.value)
          }/>
        <Input
         style={{ display: 'block' }}
        onChange={(event) =>
            setPass(event.target.value)
          } placeholder="Mot de passe" value={pass} type={"password"} required/>
        <Button
              variant="solid"
              color="primary"
              loading={loading}
              onClick={() => setLoading(true)}
            >
              Connexion
            </Button>
    </div>;
};

export default LoginPage;