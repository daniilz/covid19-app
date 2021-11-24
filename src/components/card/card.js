import React, { Component } from 'react';


class Card extends Component{

  constructor(props){
    super(props);
  }
  

  render(){
    return(
      
        <div className="card-container">
          <div className="card">
            <div className="card-body">
              {this.props.children}
            </div>
          </div>
        </div>

    )  
  }

}

export default Card;