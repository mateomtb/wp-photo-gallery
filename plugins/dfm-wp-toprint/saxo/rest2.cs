
        public string postImage(Uri address, string username, string password, ref string message, byte[] binaryimage )
        {
            string location = "";
            try
            {
                WebClient wc = new WebClient();
                wc.Credentials = new System.Net.NetworkCredential(username, password);
                byte[] bret = wc.UploadData(address, "POST", binaryimage); 
                string sret = System.Text.Encoding.ASCII.GetString(bret);
                location = wc.ResponseHeaders["Location"].ToString();
            }
            catch (Exception e)
            {
                message = e.Message;
            }
            return location;
        } // postImage




        public string postStory(Uri address, string username, string password, string strData ,ref string message)
        {
            string location = "";
            try
            {
                WebClient wc = new WebClient();
                wc.Credentials = new System.Net.NetworkCredential(username, password);
                byte[] bret = wc.UploadData(address, "POST", System.Text.Encoding.ASCII.GetBytes(strData));
                string sret = System.Text.Encoding.ASCII.GetString(bret);
                location = wc.ResponseHeaders["Location"].ToString();
            }
            catch (Exception e)
            {
                message = e.Message;
            }
            return location;
        } // postStory



