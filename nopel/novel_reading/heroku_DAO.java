package DAO;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
 * 全DAO共通の処理を記載する
 * 各DAOで継承することで、メソッドをそのまま使用できるようにする
 */
public abstract class CommonDAO {

	/***
	 * コネクション作成
	 * DBに接続する際に実行する
	 * @return 生成されたコネクションを返す
	 */
	public Connection createConnection() throws SQLException, ClassNotFoundException {
		
		final String HOST_NAME = "us-cdbr-east-06.cleardb.net";
		final String DATABASE_NAME = "heroku_2f3b6b48ea915ce";
		final String USER_NAME = "b0ff44e5a8c146";
		final String PASSWORD = "7f35a601";
	
			// postgreSQLのJDBCドライバを読み込み
			Class.forName("com.mysql.cj.jdbc.Driver");

		

		//String url = "jdbc:mysql://" + HOST_NAME + "/" + DATABASE_NAME;
		 String url = "jdbc:mysql://us-cdbr-east-06.cleardb.net/heroku_2f3b6b48ea915ce";

		Connection con = DriverManager.getConnection(url, USER_NAME, PASSWORD);
		

		return con;
} 

	/**
	 * 全件検索するSelect文を作成する
	 * @param 検索したいテーブル名を渡す
	 * @return 全件検索Select文を返す
	 */
	protected String createSelectAllSql(String strTableName) {
		String strSql = "";
		StringBuilder sb = new StringBuilder();
		sb.append("SELECT * FROM ");
		sb.append(strTableName);

		strSql = sb.toString();
		return strSql;
	}

	/**
	 * Insertを実行する
	 * @param 実行したいInsert文を渡す
	 * @return Insertの実行結果を返す(実行件数)
	 *          成功：1
	 *          失敗：0
	 * @throws ClassNotFoundException 
	 * @throws Exception
	 */
	public int exeInsert(String strSql) throws ClassNotFoundException {
		Connection conn = null;
		Statement stmt = null;
		int num = 0;
		try {
			conn = createConnection();
			stmt = conn.createStatement();
			num = stmt.executeUpdate(strSql);

		} catch (SQLException e) {
			e.printStackTrace();
		} finally {
			try {
				close(stmt);
				close(conn);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return num;
	}

	/**
	 * Updateを実行する
	 * @param 実行したいUpdate文を渡す
	 * @return Updateの実行結果を返す(実行件数)
	 *          成功：1
	 *          失敗：0
	 * @throws ClassNotFoundException 
	 * @throws Exception
	 */
	public int exeUpdate(String strSql) throws ClassNotFoundException {
		Connection conn = null;
		Statement stmt = null;
		int num = 0;
		try {
			conn = createConnection();
			stmt = conn.createStatement();
			num = stmt.executeUpdate(strSql);
		} catch (SQLException e) {
			e.printStackTrace();
		} finally {
			try {
				close(stmt);
				close(conn);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return num;
	}

	/**
	 * Deleteを実行する
	 * @param 実行したいDelete文を渡す
	 * @return Deleteの実行結果を返す(実行件数)
	 *          成功：1
	 *          失敗：0
	 * @throws ClassNotFoundException 
	 * @throws Exception
	 */
	public int exeDelete(String strSql) throws ClassNotFoundException {
		Connection conn = null;
		Statement stmt = null;
		int num = 0;
		try {
			conn = createConnection();
			stmt = conn.createStatement();
			num = stmt.executeUpdate(strSql);

			return num;
		} catch (SQLException e) {
			e.printStackTrace();
		} finally {
			try {
				close(stmt);
				close(conn);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return num;
	}
	
	
	
	


	/**
	 * コネクションをクローズする
	 * DB処理終了時に必ず実行する
	 * @param conn
	 * @throws Exception
	 */
	protected void close(Connection conn) {
		if (conn != null) {
			try {
				conn.close();
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
	}

	/**
	 * ステートメントをクローズする
	 * DB処理終了時に必ず実行する
	 * @param statement
	 * @throws Exception
	 */
	protected void close(Statement statement) {
		if (statement != null) {
			try {
				statement.close();
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
	}

	/**
	 * 結果セットをクローズする
	 * DB処理終了時に必ず実行する
	 * @param rs
	 * @throws Exception
	 */
	protected void close(ResultSet rs) {
		if (rs != null) {
			try {
				rs.close();
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
	}
	
	protected void close(int rs) {
		if(rs == 1) {
			rs = 0;
		}
	}
	
}

