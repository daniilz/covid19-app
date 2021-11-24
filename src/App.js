import React, { Component } from 'react';
import './App.css';

import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";


import axios from 'axios';



import Home from "./components/home/home";
import Country from "./components/country/country";
//import Navbar from "./shared/navbar/navbar";
import Register from "./components/register/register";
import Login from "./components/login/login";
//import Login from "./components/login/login";
//import { Router } from 'react-router';


class App extends Component{

  constructor(props){
    super(props);
  }
  
  render(){
    return(
      <Router>
        <Routes>
            <Route path='/' element={<Home/>} />  
            <Route path='/country' element={<Country/>} />  
            <Route path='/register' element={<Register/>} />  
            <Route path='/login' element={<Login/>} />                               
        </Routes>
      </Router>
    )
  }

}

export default App;
