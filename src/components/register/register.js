import { Alert } from 'bootstrap';
import React, { Component } from 'react';

import Navbar from "../../shared/navbar/navbar";
//import './App.css';
import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";


import axios from 'axios';


class Register extends Component{

    constructor(props){
        super(props);
        this.state = {
            user:{username:"",password:""}
        }
    }

    onTextChange = (e,origin)=>{
        let {user} = this.state;
        switch(origin){
            case "username": this.setState({user:{...user,username:e.target.value}});break;
            case "password": this.setState({user:{...user,password:e.target.value}});break;

        }
    }

    submitRegister = async() =>{
        let {user} = this.state;
        let formData = new FormData();

        if((user.username==="") || (user.password==="")) {
            alert("These fields are required");
        } else{
            formData.append("username",user.username);
            formData.append("password",user.password);
        

            let url = "http://localhost/covid19-app/register.php";

            axios({
                method: 'post',
                url: url,
                data: formData
            }).then((response)=>{
                //console.log(response);
                //alert(JSON.stringify(response));
                /*if(response.data.status === 200) {
                    alert("Registration successful!");
                    window.location.href="/login";
                } else {
                    alert("Registration failed!");
                }*/
                alert("Registration successful!");
                window.location.href="/login";
            });

        }
    }

    render(){
        let {user} = this.state;
        return(
            <div>
                <Navbar />
                <div className="container">
                    <div class="row align-items-center justify-content-center">
                        <div className="col-lg-4 col-md-12">
                            <h3 className = "text-center">Register</h3>
                            <br/>
                            <div className = "card">
                                <div className = "card-body">
                                    <div className = "form-group">
                                        <label>Username</label>
                                        <input className="form-control" type="text" value={user.username} onChange={(e)=>this.onTextChange(e,"username")}/>
                                        <label>Password</label>
                                        <input className="form-control" type="password" value={user.password} onChange={(e)=>this.onTextChange(e,"password")}/>
                                        <button className="btn btn-block btn-primary" onClick={()=>{ this.submitRegister();}}>Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )   
    }
}

export default Register;