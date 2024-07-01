CREATE DATABASE CSDL
COLLATE Vietnamese_CI_AS;
GO

USE CSDL;
GO

-- Bảng danh mục (Category)
CREATE TABLE Category (
    id int PRIMARY KEY IDENTITY,
    category NVARCHAR(255),
	title NVARCHAR(255),
	category_img varchar(255)
);
--Bảng tin nhanh (New)
CREATE TABLE New(
	id int PRIMARY KEY IDENTITY,
	title_new NVARCHAR(255),
	image_new NVARCHAR(255),
	describe Ntext,
    author NVARCHAR(255),
	image_author NVARCHAR(255),
	date datetime,
);
-- Bảng bài viết (Article)
CREATE TABLE Article (
    id INT PRIMARY KEY,
    id_new INT,
    content NVARCHAR(MAX),
    image1 NVARCHAR(255),
	image2 NVARCHAR(255),
    image3 NVARCHAR(255),
	image4 NVARCHAR(255),
    FOREIGN KEY (id_new) REFERENCES New(id)
);

-- Bảng người dùng (Users)
CREATE TABLE Users (
    id INT PRIMARY KEY IDENTITY,
    username NVARCHAR(255),
    email NVARCHAR(255),
	pass_word nvarchar(30),
);


-- Bảng bình luận (Comment)
CREATE TABLE Comment (
    id INT PRIMARY KEY IDENTITY,
    content NVARCHAR(MAX),
    date_comment date,
    id_user INT,
    id_article INT,
    FOREIGN KEY (id_user) REFERENCES Users(id),
    FOREIGN KEY (id_article) REFERENCES Article(id)
);

-- Bảng yêu thích (Favorite)
CREATE TABLE Favorite (
    id INT PRIMARY KEY,
    id_user INT,
    id_article INT,
    FOREIGN KEY (id_user) REFERENCES Users(id),
    FOREIGN KEY (id_article) REFERENCES Article(id)
);
--ALTER TABLE Users
--DROP CONSTRAINT FK_Users_Permission;
--ALTER TABLE Users
--DROP COLUMN id_permission;

INSERT INTO Category (category,title,category_img) 
VALUES (N'Phân loại',N'Phân loại chai nhựa,giấy, áo quần,..','./static/img/miss/4.jpg')
INSERT INTO Category (category,title,category_img) 
VALUES (N'Giải pháp',N'Cách xử lý và sử dụng hiệu quả rác thải tại nhà ,giảm rác thải sinh hoạt.','./static/img/don/sneakers.jpg')
INSERT INTO Category (category,title,category_img) 
VALUES (N'Giới thiệu về chúng tôi',N'Quá trình hình thành và phát triển của chúng tôi','./static/img/don/logo4.png')
INSERT INTO Category (category,title,category_img) 
VALUES (N'Tình nguyện viên',N'Tuyển tình nguyện viên cho dự án của chúng tôi.','./static/img/don/gadgets.jpg')
INSERT INTO Category (category,title,category_img) 
VALUES ('Thu gom',N'Sự kiện thu gom tái tạo năng lượng bảo vệ môi trường tích cực.','./static/img/don/book.png')
INSERT INTO Category (category,title,category_img) 
VALUES (N'Nhà tài trợ',N'Giới thiệu về nhà tài trợ và cách trở thành nhà tài trợ của nhóm cộng đồng chúng tôi.','./static/img/don/shopping-bag.jpg')


SELECT * FROM Category


INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Cách tái chế giấy tại nhà đơn giản, hữu ích',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://images.unsplash.com/photo-1717457781822-209ea2005287?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'10/4/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Nói không với túi nilon, chọn lựa tương lai xanh.',
N'https://images.unsplash.com/photo-1717321677309-8916f9b0a1d6?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'11/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Túi vải thay túi nilon, bảo vệ môi trường từ những việc nhỏ.',
N'https://images.unsplash.com/photo-1717457782113-42ff5f18a742?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://images.unsplash.com/photo-1582408921715-18e7806365c1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'12/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Hãy để đại dương không còn nhựa, từ bỏ túi nilon ngay hôm nay.',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://images.unsplash.com/photo-1595278069441-2cf29f8005a4?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'1/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Hãy biến trái đất thành một hành tinh xanh – Bắt đầu từ việc vứt rác đúng nơi quy định!',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'10/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Hãy để đại dương không còn nhựa, từ bỏ túi nilon ngay hôm nay.',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'1/4/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Nhựa không phân hủy, nhưng chúng ta có thể thay đổi. Sử dụng túi vải!',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'2/4/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Hãy là người bạn của Trái Đất, bảo vệ môi trường từ hành động nhỏ.',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'3/4/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Cách tái chế giấy tại nhà đơn giản, hữu ích',
N'https://images.unsplash.com/photo-1528323273322-d81458248d40?q=80&w=1858&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'4/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Dùng ít, sống tốt hơn – Bảo vệ môi trường là trách nhiệm của chúng ta.',
N'https://images.unsplash.com/photo-1717457779749-7a6707d042ad?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'1/5/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Cách tái chế giấy tại nhà đơn giản, hữu ích',
N'https://images.unsplash.com/photo-1717501219008-5f436ead74d5?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'1/3/2024')
INSERT INTO New(title_new,image_new,describe,author,image_author,date) 
VALUES (N'Nước ngọt không phải là vô hạn – Tiết kiệm và bảo vệ mỗi ngày',
N'https://plus.unsplash.com/premium_photo-1711311020952-dce422df1a3c?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',N'Khi nói đến những hành động vì môi trường, cắt giảm tiêu thụ luôn là ưu tiên hàng đầu. 
Cleanipedia sẽ gợi ý bạn một số cách tái chế giấy giúp hạn chế lượng chất thải từ giấy cũng như bảo vệ môi trường bạn nhé!',N'Bonnie',
N'https://plus.unsplash.com/premium_photo-1682146151884-40fe6fcc284f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
N'1/3/2024')


SELECT * FROM NEW
SELECT * FROM Users
SELECT COUNT(*) AS total_rows FROM New
SELECT top 1 *  FROM New ORDER BY date DESC
GO

CREATE PROCEDURE SearchNews
    @keyword NVARCHAR(255)
AS
BEGIN
    SELECT *
    FROM New
    WHERE title_new LIKE '%' + @keyword + '%'
       OR describe LIKE '%' + @keyword + '%'
       OR author LIKE '%' + @keyword + '%'
       OR CONVERT(NVARCHAR(255), date, 121) LIKE '%' + @keyword + '%'
END
GO
EXEC SearchNews @keyword = N'nước'
GO
CREATE PROCEDURE CountNewByKeyword
    @keyword NVARCHAR(255)
AS
BEGIN
    SELECT COUNT(*)
    FROM New
    WHERE title_new LIKE '%' + @keyword + '%'
       OR describe LIKE '%' + @keyword + '%'
       OR author LIKE '%' + @keyword + '%'
       OR CONVERT(NVARCHAR(255), date, 121) LIKE '%' + @keyword + '%'
END
GO
EXEC CountNewByKeyword @keyword = N'nước'

