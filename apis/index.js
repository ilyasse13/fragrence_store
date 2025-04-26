import express from 'express'
import dotenv from 'dotenv';
import sequelize from './database/connection.js';


const app=express()
dotenv.config();
const PORT = process.env.PORT || 5000;

try {
  await sequelize.authenticate();
  console.log('✅ Connection to PostgreSQL has been established successfully.');
} catch (error) {
  console.error('❌ Unable to connect to the database:', error);
}

app.get('/', (req, res) => {
  res.send('Hello from Express with PostgreSQL!');
});

app.listen(PORT, () => {
  console.log(`🚀 Server running on http://localhost:${PORT}`);
});