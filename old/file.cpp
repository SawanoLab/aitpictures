//g++ dip01.cpp `pkg-config --cflags opencv --libs opencv`
// #include <iostream>  //c++専用
#include <stdio.h> //cも使えるけど遅い
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ


int main (int argc, const char* argv[]) { //argc…プログラムの引数の数,　argv…プログラムの引数


    //①画像ファイルの読み込み
    cv::Mat src_img; //画像の型と変数
    src_img = cv::imread(argv[1]); //画像の読み込み　argv[1] は入力画像パス名
    if (src_img.empty()) { //入力失敗の場合
        fprintf(stderr, "読み込み失敗\n");
        return (1);
    }else{
        printf("画像読み込みました\n");
    }

    /* 参考　http://f-penguin.hatenablog.jp/entry/2016/06/07/192014 */
    
    //②画像格納用インスタンスの生成
    cv::Mat result_img;
    
    
    //③ウィンドウの生成と移動　
    // cv::namedWindow("Source"); //ウィンドウ生成
    // cv::moveWindow("Source", 0,0);
    // cv::namedWindow("Gray");//ウィンドウ生成
    // cv::moveWindow("Gray", 400,0);
    
    // //④画像処理
    cv::cvtColor(src_img, result_img, cv::COLOR_BGR2GRAY); //src_img→grayImage(グレースケール)

    // //④'画像処理 そのまま出力するとき用
    // cv::Mat result_img; 
    // src_img.copyTo(result_img); //結果の画像
    
    //⑤ウィンドウへの画像の表示　
    // cv::imshow("Source", src_img);　消しておく！消さないと表示される
    // cv::imshow("Gray", grayImage);
    
    //⑥キー入力待ち 
    // cv::waitKey(0);　消しておく！消さないと保存行かない

    //⑦画像の保存 //ターミナルで「./a.out　入力画像パス名　出力画像パス名（画像名は決めていい）」で保存される
    cv::imwrite(argv[2], result_img); //imwrite(出力画像パス名,格納場所)…格納場所の画像を出力画像パス名で保存する
    
    printf("ほげほげ\n");
    
    return 0;

}

// ./a.out input_img1.jpg input_img2.jpg output_img.jpg
// argv[0]   argv[1]        argv[2]         argv[3]...g1.jpg input_img2.jpg output_img.jpg
// argv[0]   argv[1]        argv[2]         argv[3]...