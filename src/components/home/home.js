import React, { Component } from 'react';
import Navbar from "../../shared/navbar/navbar";
import Card from "../../components/card/card";
//import './App.css';
import {
  BrowserRouter as Router,
  Routes,
  Route,
} from "react-router-dom";


import axios from 'axios';

class Home extends Component{

  constructor(props){
    super(props);
    this.state = {
      wdata:[]
    }
  }
  
  componentDidMount(){
    this.fetchWorldData();
  }

  fetchWorldData = async () =>{
    let url = 'https://covid19.mathdro.id/api';
  
    axios({
      method: 'get',
      url: url,
    }).then((response)=>{
        //alert(response.data.deaths.value);
        console.log(response);
        let wdata = response.data;
        /*let wdata = [
          response.data.deaths.value,
          response.data.confirmed.value,
          response.data.recovered.value
        ];*/

        /*wdata = wdata.map((item) => {
          return {deaths:item.deaths.value}
        });*/

        let wdeaths = response.data.deaths.value;
        //alert(wdata);
        /*wdata = wdata.map((item)=>{
          return {
            deaths:item.deaths.value
          };
        });
        this.setState({
          wdata
        });*/
    });  

  }


  renderContainerWorld = () => {
    //let {wdata} = this.state;
    return(
      <div>
        <h2>Case breakdown in the World</h2>
        <section className="cards-container">

          <Card>
              <h3 className="active card-title">Active</h3>
              <p className="card-text">
                253,664,004
                </p>
          </Card>

          <Card>
              <h3 className="recovered card-title">Recovered</h3>
              <p className="card-text">0</p>
          </Card>

          <Card>
              <h3 className="deceased card-title">Deceased</h3>
              <p className="card-text">5,166,649</p>
          </Card>

          <Card>
              <h3 className="total card-title">Total</h3>
              <p className="card-text">258,830,653</p>
          </Card>
        				
      </section>
    </div>     
    )  
  }

  renderContainerCountry = () => {
    return(
      <div>
      <h2>Case breakdown for India</h2>
      <section className="cards-container">

        <Card>
            <h3 className="active card-title">Active</h3>
            <p className="card-text">
              34,069,179
            </p>
        </Card>

        <Card>
            <h3 className="recovered card-title">Recovered</h3>
            <p className="card-text">0</p>
        </Card>

        <Card>
            <h3 className="deceased card-title">Deceased</h3>
            <p className="card-text">466,584</p>
        </Card>

        <Card>
            <h3 className="total card-title">Total</h3>
            <p className="card-text">34,535,763</p>
        </Card>
            
      </section>
      </div>
      
    )  
  }


  render(){
    return(
      
      <div>
        <Navbar />
        <div className="container">
          <div className="row">
            <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              {this.renderContainerWorld()}
            </div>
          </div>
        </div>

        <div className="container">
          <div className="row">
            <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {this.renderContainerCountry()}
            </div>
          </div>
        </div>        

      

    </div>
    )  
  }

}

export default Home;
