-- 上から順番に実行すれば正しくデータが入る
insert into roles values (1,"root"),(2,"common");
insert into grades values (1,"low"),(2,"middle"),(3,"high");
insert into genres values (1,"a"),(2,"b"),(3,"c");
insert into tasks values (1,"run",1,1,"run to office"),(2,"submit",2,2,"submit an idea"),(3,"wash",3,3,"wash dishes");
insert into users values (1,"taro","sample1@co.jp","pass",1),(2,"jiro","sample2@co.jp","pass",2),(3,"saburo","sample3@co.jp","pass",2),(4,"shiro","sample4@co.jp","pass",2);
insert into votes values (1,1,1),(2,2,10),(3,3,100);
insert into completes values (1,1,1),(2,2,2),(3,3,2),(4,1,3);