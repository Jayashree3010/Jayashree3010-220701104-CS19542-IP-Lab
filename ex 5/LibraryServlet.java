package com.library.servlet;

import com.library.utils.DatabaseConnection;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.*;

@WebServlet("/LibraryServlet")
public class LibraryServlet extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String action = request.getParameter("action");
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        try {
            switch (action) {
                case "viewAll":
                    viewAllBooks(out);
                    break;
                case "insert":
                    out.println(getInsertForm());
                    break;
                case "update":
                    out.println(getUpdateForm(Integer.parseInt(request.getParameter("accno"))));
                    break;
                case "delete":
                    deleteBook(Integer.parseInt(request.getParameter("accno")));
                    viewAllBooks(out);
                    break;
                default:
                    viewAllBooks(out);
                    break;
            }
        } catch (Exception e) {
            e.printStackTrace();
            out.println("<p>Error: " + e.getMessage() + "</p>");
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String action = request.getParameter("action");
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        try {
            switch (action) {
                case "insert":
                    insertBook(request);
                    viewAllBooks(out);
                    break;
                case "update":
                    updateBook(request);
                    viewAllBooks(out);
                    break;
                default:
                    viewAllBooks(out);
                    break;
            }
        } catch (Exception e) {
            e.printStackTrace();
            out.println("<p>Error: " + e.getMessage() + "</p>");
        }
    }

    private void viewAllBooks(PrintWriter out) throws SQLException, ClassNotFoundException {
        Connection conn = DatabaseConnection.getConnection();
        String query = "SELECT * FROM BOOK";
        Statement stmt = conn.createStatement();
        ResultSet rs = stmt.executeQuery(query);

        out.println("<h2>All Books</h2>");
        out.println("<table border='1'><tr><th>Acc No</th><th>Title</th><th>Author</th><th>Publisher</th><th>Edition</th><th>Price</th><th>Actions</th></tr>");

        while (rs.next()) {
            out.println("<tr><td>" + rs.getInt("ACCNO") + "</td><td>" + rs.getString("TITLE") + "</td><td>"
                    + rs.getString("AUTHOR") + "</td><td>" + rs.getString("PUBLISHER") + "</td><td>"
                    + rs.getString("EDITION") + "</td><td>" + rs.getDouble("PRICE") + "</td>"
                    + "<td><a href='LibraryServlet?action=update&accno=" + rs.getInt("ACCNO") + "'>Edit</a> | "
                    + "<a href='LibraryServlet?action=delete&accno=" + rs.getInt("ACCNO") + "'>Delete</a></td></tr>");
        }
        out.println("</table>");
        out.println("<a href='LibraryServlet?action=insert'>Add New Book</a>");
    }

    private void insertBook(HttpServletRequest request) throws SQLException, ClassNotFoundException {
        String title = request.getParameter("title");
        String author = request.getParameter("author");
        String publisher = request.getParameter("publisher");
        String edition = request.getParameter("edition");
        double price = Double.parseDouble(request.getParameter("price"));

        Connection conn = DatabaseConnection.getConnection();
        String query = "INSERT INTO BOOK (TITLE, AUTHOR, PUBLISHER, EDITION, PRICE) VALUES (?, ?, ?, ?, ?)";
        PreparedStatement stmt = conn.prepareStatement(query);
        stmt.setString(1, title);
        stmt.setString(2, author);
        stmt.setString(3, publisher);
        stmt.setString(4, edition);
        stmt.setDouble(5, price);
        stmt.executeUpdate();
    }

    private void updateBook(HttpServletRequest request) throws SQLException, ClassNotFoundException {
        int accno = Integer.parseInt(request.getParameter("accno"));
        String title = request.getParameter("title");
        String author = request.getParameter("author");
        String publisher = request.getParameter("publisher");
        String edition = request.getParameter("edition");
        double price = Double.parseDouble(request.getParameter("price"));

        Connection conn = DatabaseConnection.getConnection();
        String query = "UPDATE BOOK SET TITLE=?, AUTHOR=?, PUBLISHER=?, EDITION=?, PRICE=? WHERE ACCNO=?";
        PreparedStatement stmt = conn.prepareStatement(query);
        stmt.setString(1, title);
        stmt.setString(2, author);
        stmt.setString(3, publisher);
        stmt.setString(4, edition);
        stmt.setDouble(5, price);
        stmt.setInt(6, accno);
        stmt.executeUpdate();
    }

    private void deleteBook(int accno) throws SQLException, ClassNotFoundException {
        Connection conn = DatabaseConnection.getConnection();
        String query = "DELETE FROM BOOK WHERE ACCNO=?";
        PreparedStatement stmt = conn.prepareStatement(query);
        stmt.setInt(1, accno);
        stmt.executeUpdate();
    }

    private String getInsertForm() {
        return "<h2>Add New Book</h2><form action='LibraryServlet' method='post'>" +
                "<input type='hidden' name='action' value='insert'>" +
                "Title: <input type='text' name='title'><br>" +
                "Author: <input type='text' name='author'><br>" +
                "Publisher: <input type='text' name='publisher'><br>" +
                "Edition: <input type='text' name='edition'><br>" +
                "Price: <input type='number' step='0.01' name='price'><br>" +
                "<input type='submit' value='Add Book'>" +
                "</form>";
    }

    private String getUpdateForm(int accno) {
        return "<h2>Update Book</h2><form action='LibraryServlet' method='post'>" +
                "<input type='hidden' name='action' value='update'>" +
                "<input type='hidden' name='accno' value='" + accno + "'>" +
                "Title: <input type='text' name='title'><br>" +
                "Author: <input type='text' name='author'><br>" +
                "Publisher: <input type='text' name='publisher'><br>" +
                "Edition: <input type='text' name='edition'><br>" +
                "Price: <input type='number' step='0.01' name='price'><br>" +
                "<input type='submit' value='Update Book'>" +
                "</form>";
    }
}
