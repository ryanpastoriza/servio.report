<li class="dropdown tasks-menu">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
     <i class="fa fa-flag-o"></i>
     <span class="label label-danger"><?= $count > 0 ? $count : ""  ?></span>
   </a>
   <ul class="dropdown-menu">
     <li class="header"><?= isset($title) && $title != false ? $title : "" ?></li>
     <li>
       <ul class="menu">
        <?php if (isset($notifs) && $notifs): ?>
          <?php foreach ($notifs as $key => $value): ?>
              <li>
               <a href="#">
                  <?= $value['notification'] ?>
               </a>
             </li>
          <?php endforeach ?>
        <?php endif ?>
       </ul>
     </li>
     <?php if (isset($footer) && $footer != false): ?>
       <li class="footer">
         <a href="<?= $footer['link'] ?>"> <?= $footer['text'] ?></a>
       </li>
     <?php endif ?>
   </ul>
 </li>