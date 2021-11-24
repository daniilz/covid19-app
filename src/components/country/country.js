import React, { Component } from 'react';
//import './App.css';
import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";


import axios from 'axios';

class Country extends Component{

  constructor(props){
    super(props);
    this.state = {
      country:[]
    }
  }
  
  componentDidMount(){
    this.fetchCountry();
  }

  fetchCountry = async () =>{
    let url = 'https://covid19.mathdro.id/api';
  
    axios({
      method: 'get',
      url: url,
    }).then(function (response) {
        //if(response.data === 200 || response.data === 201) {
          let country = response.data;
          
        //} else {
          //alert('!');
          //let country = response.data;
        //}
        
        console.log(response);
    });  

  }

  renderContainerWorld = () => {
    return(
      <h2>Case breakdown in the World1</h2>
    )  
  }
  renderContainerCountry = () => {
    return(
      <h2>Case breakdown by Country</h2>
    )  
  }


  render(){
    return(
      <div>
        {this.renderContainerWorld()}

      {this.renderContainerCountry()}

    </div>
    )  
  }

}

export default Country;
