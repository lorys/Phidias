import logo from './logo.svg';
import './App.css';
import { useState } from 'react';
import LoginPage from './LoginPage';

const Storage = () => <></>;
function App() {
  const [loggedIn, setLoggedIn] = useState(false);
  
  return (
    <div className="App">
      {!loggedIn ? <LoginPage /> : <Storage />}
    </div>
  );
}

export default App;
