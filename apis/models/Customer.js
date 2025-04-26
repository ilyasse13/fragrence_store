// models/Customer.js
import { DataTypes } from 'sequelize';
import sequelize from '../database/connection.js';


const Customer = sequelize.define('Customer', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true,
  },
  
  name: {
    type: DataTypes.STRING,
    allowNull: false,
    trim: true,
  },
  
  email: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true,
    trim: true,
    lowercase: true,
  },
  
  password: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  
  address: {
    type: DataTypes.JSON,
    allowNull: true,
  },
  
  remember_token: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  
  image: {
    type: DataTypes.STRING,
    allowNull: true,
    trim: true,
  },
  
  is_verified: {
    type: DataTypes.BOOLEAN,
    defaultValue: false,
  },
  
  last_login: {
    type: DataTypes.DATE,
    allowNull: true,
  },
  
  reset_password_token: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  
  reset_password_expires_at: {
    type: DataTypes.DATE,
    allowNull: true,
  },
  
  verification_token: {
    type: DataTypes.STRING,
    allowNull: true,
  },
  
  verification_token_expires_at: {
    type: DataTypes.DATE,
    allowNull: true,
  },
}, {
  tableName: 'customers', // very important: tell Sequelize the real table name
  timestamps: true, // createdAt and updatedAt
});

export default Customer;
