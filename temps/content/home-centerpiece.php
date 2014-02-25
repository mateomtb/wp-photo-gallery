<div class="lead-story">
    <div class="media single-img">
        <?php include('temps/ui/resp-photo.php'); ?>
    </div> <!-- .media -->
    <h2><a href="">Ramseys accused of child abuse resulting in 1999 grand jury indictment</a></h2>
    <p class="excerpt">DA Boulder grand jury indictment in 1999 accused John and Patsy Ramsey of two counts each of child abuse resulting in death in connection to the first-degree murder of their 6-year-old daughter JonBenét, according to documents released Friday morning. <span class="timestamp">21m ago</span></p>
    <?php if($secondstory) :?>
    </div> <!-- .lead-story -->
    <div class="second-lead-story">
        <h3><a href="">Denver home sales continue to climb</a></h3>
        <p class="excerpt">The metro Denver housing market continued to show improvement over a year ago, while the number of homes available for sale remained down considerably.</p>
        <div class="meta">
            <p class="source">The Associated Press<span class="divider">|</span><time datetime="2012-03-05T20:53Z" class="timestamp">3 hours ago</time></p>
            <p class="comment-bug"><span class="glyphicon glyphicon-comment"></span><span class="sr-only">Comments: </span><a href="">62</a></p>
        </div>
    </div> <!-- .second-lead-story -->
    <?php else :?>
    <div class="link-list">
        <h5>Related stories</h5>
        <ul>
            <li><a href=""><strong>Documents:</strong> Read portions of the unsealed indictment</a></li>
            <li><a href=""><strong>Boulder police:</strong> Read a statement about the latest unsealed documents</a></li>
            <li><a href=""><strong>Charlie Brennan:</strong> Why I fought for the Ramsey indictment's release</a></li>
            <li><a href=""><strong>Slideshow:</strong> Images related to the JonBenet Ramsey case</a></li>
        </ul>
    </div>
</div> <!-- .lead-story -->
<?php endif; ?>