import { useState, useEffect } from "react";
import axios from "axios";

function App() {
  const [form, setForm] = useState({ name: "", email: "" });
  const [users, setUsers] = useState([]);

  const fetchUsers = async () => {
    const res = await axios.get(
      "http://localhost/LearningPhp/AdditionalTasks/BonusTaskReactJS/Backend/FetchData.php"
    );
    setUsers(res.data);
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await axios.post(
      "http://localhost/LearningPhp/AdditionalTasks/BonusTaskReactJS/Backend/InsertData.php",
      form
    );
    setForm({ name: "", email: "" });
    fetchUsers();
  };

  return (
    <div>
      <h2>Insert User</h2>
      <form onSubmit={handleSubmit}>
        <input
          placeholder="Name"
          name="name"
          value={form.name}
          onChange={handleChange}
          required
        />
        <input
          placeholder="Email"
          type="email"
          name="email"
          value={form.email}
          onChange={handleChange}
          required
        />
        <button type="submit">Submit</button>
      </form>

      <h2>All Users</h2>
      <table border="1" cellPadding="5">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          {users.map((u) => (
            <tr key={u.id}>
              <td>{u.id}</td>
              <td>{u.name}</td>
              <td>{u.email}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default App;
